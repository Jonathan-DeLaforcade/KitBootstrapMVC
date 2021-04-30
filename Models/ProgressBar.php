<?php
class ProgressBar {
    private $_bars;

    public function __construct() {
        $this->_bars = array();
    }

    public function addBar($title = "",$value = 0,$color = "primary") {
        
        $line = array(
            "title" => $title,
            "value" => $value,
            "color" => $color
        );

        array_push($this->_bars,$line);
    }

    public function GenerateHTML() {
        ob_start();
        foreach ($this->_bars as $line) {
            ?>
                <h4 class="small font-weight-bold"><?php echo $line["title"]; ?><span class="float-right"><?php echo $line["value"]; ?>%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-<?php echo $line["color"]; ?>" role="progressbar" style="width: <?php echo $line["value"]; ?>%" aria-valuenow="<?php echo $line["value"]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            <?php
        }
        return ob_get_clean();
    }
}