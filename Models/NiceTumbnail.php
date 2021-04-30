<?php 

class NiceTumbnail {
    private $_title;
    private $_typeOfValue;
    private $_value;
    private $_color;
    private $_icon;
    private $_result;

    public function __construct($title = "", $value = 0, $typeOfValue = "number",$icon = "fas fa-calendar",$color = "primary") {
        $this->_title = $title;
        $this->_typeOfValue = $typeOfValue;
        $this->_value = $value;
        $this->_icon = $icon;
        $this->_color = $color;
    }

    public function Generate() {
        ob_start();
        ?>
        <div class="card border-left-<?=$this->_color?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-<?=$this->_color?> text-uppercase mb-1"><?=$this->_title?></div>
                        <?php if ($this->_typeOfValue == "percent") { ?>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$this->_value?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-<?=$this->_color?>" role="progressbar" style="width: <?=$this->_value?>%" aria-valuenow="<?=$this->_value?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$this->_value?></div>
                        <?php } ?>
                    </div>
                    <div class="col-auto">
                        <i class="<?=$this->_icon?> fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}