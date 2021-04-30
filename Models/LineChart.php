<?php 

class LineChart {
    private $_templateFile;
    private $_linesArray;
    private $_finaleStyle;

    public function __construct($canvas = "",$label = array()) {
        $this->_linesArray = array();

        ob_start();
        ?>
        <script>
        var ctxL = document.getElementById("<?php echo $canvas; ?>").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: ["<?php echo implode('","', $label); ?>"],
                datasets: [
        <?php
        $this->_finaleStyle = ob_get_clean();
    }

    private function end() {
        ob_start();
        ?>
            },
        options: {
        responsive: true
        }
        });
        </script>
        <?php
        $this->_finaleStyle .= ob_get_clean();
    }

    // AddLine(text,data array(),bgcolor,bordercolor)
    public function AddLine($label = "",$data = array(),$BgColor = 'rgba(105, 0, 132, 0.2)',$bordercolor = 'rgba(200, 99, 132, .7)') {
        $line = array(
            "label" => $label,
            "data" => $data,
            "BgColor" => $BgColor,
            "bordercolor" => $bordercolor
        );

        array_push($this->_linesArray,$line);
    }

    public function Generate() {
        $numItems = count($this->_linesArray);
        $i = 0;
        ob_start();
        foreach ($this->_linesArray as $line) { ?>
            {
            label: '<?php echo $line["label"]; ?>',
            data: [<?php echo implode(',', $line["data"]); ?>],
            
            backgroundColor: ['<?php echo $line["BgColor"]; ?>'],
            borderColor: ['<?php echo $line["bordercolor"]; ?>'],
            borderWidth: 2
            }
            <?php 
            echo ( ($i==count($this->_linesArray))? "":",") ;
            $i++;
        }
        $this->_finaleStyle .= ob_get_clean();
        $this->_finaleStyle = $this->_finaleStyle."]";
        $this->end();
        return $this->_finaleStyle;
    }
}