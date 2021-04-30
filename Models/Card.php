<?php 

class Card {
    private $_ID;
    private $_title;
    private $_contenue;
    private $_mode;
    private $_dropdownData;

    public function __construct($title = "",$contenue = "",$mode = "basic",$dropdownData = array()) {
        $this->_title = $title;
        $this->_contenue = $contenue;
        $this->_mode = $mode;
        $this->_dropdownData = $dropdownData;

        $tmpID = "IDCollapse";
        $tmpID .= rand(0,9999999999999);
        $this->_ID = $tmpID;
    

    }


    public function GenerateHTML() {
        ob_start();
        ?>
            <div class="card shadow mb-4">
                <?php if ($this->_mode == "collapse") { ?>
                    <a href="#<?=$this->_ID?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="<?=$this->_ID?>">
                <?php } elseif ($this->_mode == "dropdown") { ?>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <?php } else { ?>
                    <div class="card-header py-3">
                <?php } ?>
                    <h6 class="m-0 font-weight-bold text-primary"><?=$this->_title?></h6>
                    <?php if ($this->_mode == "dropdown") { ?>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="<?=$this->_ID?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <?php 
                                foreach ($this->_dropdownData as $data) {
                                    if ($data[0] == "*") {
                                ?>
                                        <div class='dropdown-header'><?=ltrim($data, $data[0])?></div>
                                <?php } else if ($data == "-") { ?>
                                        <div class='dropdown-divider'></div>
                                <?php } else { ?>
                                        <a class="dropdown-item" href='#'><?=$data?></a>
                                <?php }} ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php if ($this->_mode == "collapse") { ?>
                    </a>
                <?php } else { ?>
                    </div>
                <?php } ?>
                <?php if ($this->_mode == "collapse") { echo "<div class='collapse show' id='".$this->_ID."'>";} ?>
                <div class="card-body">
                    <?=$this->_contenue?>
                </div>
                <?php if ($this->_mode == "collapse") { echo "</div>";}?>
            </div>
        <?php
        return ob_get_clean();
    }
}