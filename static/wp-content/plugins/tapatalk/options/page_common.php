<?php
class PageCommon{
    private static $_instance;

    public static function getInstance(){
        if (!self::$_instance instanceof self){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){}

    private function __clone(){}

    public function create_opening_tag($value) {
        $group_class = "";
        if (isset($value['grouping'])) {
            $group_class = "suf-grouping-rhs";
        }
        echo '<div class="suf-section fix">'."\n";
        if ($group_class != "") {
            echo "<div class='$group_class fix'>\n";
        }
        if (isset($value['name'])) {
            echo "<h3>" . $value['name'] . "</h3>\n";
        }
        if (isset($value['desc']) && !(isset($value['type']) && $value['type'] == 'checkbox')) {
            echo $value['desc']."<br />";
        }
        if (isset($value['note'])) {
            echo "<span class=\"note\">".$value['note']."</span><br />";
        }
    }

    /**
     * Creates the closing markup for each option.
     *
     * @param $value
     * @return void
     */
    public function create_closing_tag($value) {
        if (isset($value['grouping'])) {
            echo "</div>\n";
        }
        //echo "</div><!-- suf-section -->\n";
        echo "</div>\n";
    }

    public function create_suf_header_3($value) { echo '<h3 class="suf-header-3">'.$value['name']."</h3>\n"; }

    public function create_section_for_checkbox($value) {
        $this->create_opening_tag($value);
        $options = $value['options'];
        $checked = ' ';
        if (isset($value['group'])) {
            $group_value = get_option($value['group']);
            if ($group_value && isset($group_value[$value['id']]) && $group_value[$value['id']]){
                $checked = ' checked="checked" ';
            }
        }else if (get_option($value['id'])){
            $checked = ' checked="checked" ';
        }

        echo '<input type="checkbox" name="'.$value['group']."[".$value['id'].']" value="true" '.$checked.' />'.$options['desc']."\n";
        $this->create_closing_tag($value);
    }

    public function create_section_for_text($value) {
        $this->create_opening_tag($value);
        $text = "";
        if (isset($value['group']) && $this->get_group_options_value($value['group'], $value['id'])){
            $text = $this->get_group_options_value($value['group'], $value['id']);
        }else if (get_option($value['id'])) {
            $text = get_option($value['id']);
        }
        else {
            $text = $value['std'];
        }

        echo '<input style="width:90%" type="text" id="'.$value['id'].'" placeholder="'.$value['title'].'" name="'.$value['group']."[".$value['id'].']" value="'.$text.'" />'."\n";
        $this->create_closing_tag($value);
    }

    public function get_group_options_value($group, $index){
        $group_value = get_option($group);
        return isset($group_value[$index]) ? $group_value[$index] : false;
    }
}