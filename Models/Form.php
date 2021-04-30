<?php 

class Form {
    private $titles;
    private $inputs;
    private $action;

    public function __construct($action = "",$title = false) {
        $this->titles = $title;
        $this->action = $action;
        
    }

    public function createInput($ID = "", $name = "text",$txt = "",$valueIn = "",$precompleteValue = "") {
        $value = '<div class="form-group row">';
        if ($valueIn == "") {
            $valueIn = $txt;
        }
        if ($this->titles) {
            $value .= '<label class="col-sm-4 col-form-label">'.$txt.'</label>';
            $value .= '<input id="'.$ID.'" onchange="HashPass(this)" type="'. $name .'" name="'. $ID .'"class="col-sm-8 form-control form-control-user" placeholder="'.$valueIn.'" value="'.$precompleteValue.'">';
        } else {
            $value .= '<input id="'.$ID.'" onchange="HashPass(this)" type="'. $name .'" name="'. $ID .'"class="form-control form-control-user" placeholder="'.$valueIn.'" value="'.$precompleteValue.'">';
        }
        $value .= '</div>';

        $this->inputs = ($this->inputs.$value);
    }

    public function createCheck($txt = "") {
        $value = '<div class="form-group">';
        $value .= '<div class="custom-control custom-checkbox small">';
        $value .= '<input type="checkbox" class="custom-control-input" id="customCheck"> <label class="custom-control-label" for="customCheck">'.$txt.'</label>';
        $value .= '</div>';
        $value .= '</div>';

        $this->inputs = ($this->inputs.$value);
    }

    public function createSubmit($txt = "Connexion") {
        $value = '<div class="form-group">';
        if ($JSOnClick != "") {
            $value .= '<button id="SubButton" type="submit" class="btn btn-primary btn-user btn-block">'.$txt.'</button>';
        } else {
            $value .= '<button id="SubButton" type="submit" class="btn btn-primary btn-user btn-block">'.$txt.'</button>';
        }
        $value .= '</div>';

        $this->inputs = ($this->inputs.$value);
    }

    public function generateHTML() {
        return '<form class="user ml-2 mr-2" method="POST" action='.$this->action.'>'.$this->inputs.'</form>';
    }

    public function generateJS() {
        ob_start();
        ?>
        <script>
            function HashPass(input) {
                if (input.type == "password") {
                    input.value = hex_md5(input.value);
                }
            }
        </script>
        <?php
        return ob_get_clean();
    }
}