<?php 

class CircleChart {
    private $_circleID;
    private $_labels;
    private $_datas;
    private $_colors;

    public function __construct($id = "") {
        $this->_circleID = $id;
        $this->_labels = array();
        $this->_datas = array();
        $this->_colors = array();
    }


    public function addData($valueName = "",$valueQty = 0, $valueColor = "#FFFFFF") {
        if ($valueQty > 0) {
            if ($valueColor == "#FFFFFF") {
                $valueColor = "#".substr(md5(rand()), 0, 6);
            }

            array_push($this->_labels,$valueName);
            array_push($this->_datas,$valueQty);
            array_push($this->_colors,$valueColor);
        }
    }

    public function GenerateJS() {
        ob_start();

        $number = array(1,5,15,25,50);
        ?>
        <script>
            var circle = document.getElementById("<?=$this->_circleID?>");
            var circleColor = getRandomColor();
            var Number = circle.getAttribute("Number");
            console.log(Number);
            new Chart(circle , {
            type: 'doughnut',
            data: {
                labels: ["<?php echo implode('","',$this->_labels); ?>"],
                datasets: [{
                data: [<?php echo implode(',',$this->_datas); ?>],
                backgroundColor: ["<?php echo implode('","',$this->_colors); ?>"],
                hoverBackgroundColor: ["<?php echo implode('","',$this->_colors); ?>"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "#FFFFFF",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: true
                },
                cutoutPercentage: 80,
            },
            });



            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        </script>

        <?php
        return ob_get_clean();
    }

    public function GenerateHTML() {
        ob_start();
        ?>
        <div class="chart-pie pt-4 pb-2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="<?=$this->_circleID?>" Number=10,15,20 width="486" height="245" class="chartjs-render-monitor" style="display: block; width: 486px; height: 245px;"></canvas>
        </div>
        <div class="mt-4 text-center small">
            <?php
            foreach ($this->_data as $data){
            ?>
                <span class="mr-2">
                    <i class="fas fa-circle text-primary"></i><?=$data[0]?>
                </span>
            <?php 
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}