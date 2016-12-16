#!/usr/bin/env python3
# -*- coding: utf-8 -*-
'''
A simple program which migrates an exported Ghost blog to Hugo.
It assumes your blog is using the hugo-icarus theme, but should
work for any theme. The script will migrate your posts, including
tags and banner images. Furthermore, it will make sure that
all your old post urls will keep working by adding aliases to them.
The only thing you need to do yourself is copying the `images/`
directory in your ghost directory to `static/images/` in your hugo
directory. That way, all images will work. The script will rewrite
all urls linking to `/content/images` to just `/images`.
'''

import argparse
import json
from datetime import date
from os import path
from collections import defaultdict
import re

_post = '''
+++
date = "{date}"
draft = {draft}
title = "{title}"
slug = "{slug}"
tags = {tags}
banner = "{banner}"
aliases = {aliases}
+++
{markdown}
'''


def migrate(filepath, hugodir):
    '''
    Parse the Ghost json file and write post files
    '''
    with open(filepath, "r") as fp:
        ghost = json.load(fp)

    data = ghost['db'][0]['data']

    tags = {}
    for tag in data["tags"]:
        tags[tag["id"]] = tag["name"]

    posttags = defaultdict(list)

    for posttag in data["posts_tags"]:
        posttags[posttag["post_id"]].append(tags[posttag["tag_id"]])

    for post in data['posts']:
        draft = "true" if post["status"] == "draft" else "false"
        ts = int(post["created_at"]) / 1000

        banner = "" if post["image"] is None else post["image"]
        # /content/ should not be part of uri anymore
        banner = re.sub("^.*/content[s]?/", "/", banner)

        target = path.join(hugodir, "content/post",
                           "{}.md".format(post["slug"]))

        aliases = ["/{}/".format(post["slug"])]

        print("Migrating '{}' to {}".format(post["title"],
                                          target))

        hugopost = _post.format(markdown=post["markdown"],
                                title=post["title"],
                                draft=draft,
                                slug=post["slug"],
                                date=date.fromtimestamp(ts).isoformat(),
                                tags=posttags[post["id"]],
                                banner=banner,
                                aliases=aliases)

        # this is no longer relevant
        hugopost = hugopost.replace("```language-", "```")
        # /content/ should not be part of uri anymore
        hugopost = hugopost.replace("/content/", "/")
        hugopost = re.sub("^.*/content[s]?/", "/", hugopost)

        with open(target, 'w') as fp:
            print(hugopost, file=fp)


def main():
    parser = argparse.ArgumentParser(
        description="Migrate an exported Ghost blog to Hugo")
    req = parser.add_argument_group(title="required arguments")
    req.add_argument("-f", "--file", help="JSON file exported from Ghost",
                     required=True)
    req.add_argument("-d", "--dir", help="Directory (root) of Hugo site",
                     required=True)

    args = parser.parse_args()

    migrate(args.file, args.dir)


if __name__ == "__main__":
	main()
