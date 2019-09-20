<?php

if (!class_exists("Html")) {

    class Html {

        private static $_tags = [
            'a' => ['single' => false, 'require' => ['href', 'title']],
            'abbr' => ['single' => false, 'require' => ['title']],
            'address' => ['single' => false, 'require' => []],
            'area' => ['single' => true, 'require' => ['shape', 'coords', 'href', 'alt']],
            'article' => ['single' => false, 'require' => []],
            'div' => ['single' => false, 'require' => []],
            'span' => ['single' => false, 'require' => []],
            'img' => ['single' => true, 'require' => ['alt', 'src', 'title']],
            'br' => ['single' => true, 'require' => []],
            'input' => ['single' => true, 'require' => ['type']],
            'textarea' => ['single' => false, 'require' => []],
            'label' => ['single' => false, 'require' => ['for']]
        ];
        public $tagName = '';
        public $attr = [];
        public $html = '';
        public $next = null;
        public $prev = null;
        public $firstChild = null;
        public $lastChild = null;

        public function __construct() {
            //
        }

        public static function createByTagName($tagName = 'div', $attr = [], $html = "") {
            $tag = new Html;
            $tag->tagName = $tagName;
            $tag->attr = $attr;
            //Fix require attr
            $requireField = $tag->getRequireAttr();
            if (!empty($requireField)) {
                foreach ($requireField as $key => $value) {
                    if (!isset($tag->attr[$value])) {
                        $tag->attr[$value] = "";
                    }
                }
            }
            $tag->html = $html;
            return $tag;
        }

        public static function div($attr = [], $html = "") {
            return self::createByTagName('div', $attr, $html);
        }

        public static function span($attr = [], $html = "") {
            return self::createByTagName('span', $attr, $html);
        }

        public static function img($attr = [], $html = "") {
            return self::createByTagName('img', $attr, $html);
        }

        public static function textarea($attr = [], $html = "") {
            return self::createByTagName('textarea', $attr, $html);
        }

        public static function label($attr = [], $html = "") {
            return self::createByTagName('label', $attr, $html);
        }

        /*
          Set
         */

        public function setTagName($tagName = '') {
            $this->tagName = $tagName;
            return $this;
        }

        public function setAttr($attr = []) {
            if (is_array($attr)) {
                foreach ($attr as $key => $value) {
                    $this->attr[$key] = $value;
                }
            }
            return $this;
        }

        public function setHtml($html = '') {
            $this->html = $html;
            return $this;
        }

        public function setNext($tag = '') {
            $this->next = $tag;
            return $this;
        }

        public function setPrev($tag = '') {
            $this->prev = $tag;
            return $this;
        }

        public function setFirstChild($tag = '') {
            $this->firstChild = $tag;
            return $this;
        }

        public function setLastChild($tag = '') {
            $this->lastChild = $tag;
            return $this;
        }

        /*
          Get
         */

        public function getHtml() {
            return $this->html;
        }

        public function getAttr() {
            return $this->attr;
        }

        public function getTagName() {
            return $this->tagName;
        }

        public function getNext() {
            return $this->next;
        }

        public function getPrev() {
            return $this->prev;
        }

        public function getFirstChild() {
            return $this->firstChild;
        }

        public function getLastChild() {
            return $this->lastChild;
        }

        public function out() {
            $str = "";
            $str .= "<" . $this->tagName;
            if (is_array($this->attr)) {
                foreach ($this->attr as $key => $value) {
                    $str .= ' ' . $key . '="' . $value . '"';
                }
            }

            if ($this->isSingle() === true) {
                $str .= " />";
            } else {
                $str .= ">" . $this->html . "</" . $this->tagName . ">";
            }

            return $str;
        }

        private function isSingle() {
            return (self::$_tags[$this->tagName]['single'] === true);
        }

        private function getRequireAttr() {
            return (self::$_tags[$this->tagName]['require']) ? self::$_tags[$this->tagName]['require'] : [];
        }

    }

}
?>