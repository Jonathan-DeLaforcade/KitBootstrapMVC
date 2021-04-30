<?php 

class Table {
    private $data = array();
    private $table;
    private $tableName;
    private $asIdCol;
    private $actualIndex;

    public function __construct($tableName = "",$titleLine = array(), $asIdCol = false ) {
        $this->tableName = $tableName;
        $this->asIdCol = $asIdCol;
        $this->actualIndex = 1;
        ob_start();
        ?>
        <div class="container-fluid ">
        <div class="col rounded text-dark p-1">
        <table id="<?=$tableName?>" class="table table-bordered text-dark">
        <thead>
        <tr>
        <?php
        if ($asIdCol) {
            echo '<th>ID</th>'; 
        }

        foreach ($titleLine as $text) {
            echo '<th>'.$text.'</th>'; 
        }
        ?>
        </tr>
        </thead>
        <?php
        $value = ob_get_clean();
        $this->table = $value;

    }

    public function addLine($array = array(),$StatButton = array(0,"tt1"),$EditButton = array(0,"tt1"),$DelButton = array(0,"tt2")) {
        array_push($this->data,array($array,$StatButton,$EditButton,$DelButton));
    }

    
    private function createLines() {
        $value = '<tbody>';
        foreach ($this->data as $line) {
            $data = $line[0];
            
            $StatButtonActivate = $line[1][0];
            $StatButtonAction = $line[1][1];

            $EditButtonActivate = $line[2][0];
            $EditButtonAction = $line[2][1];

            $DelButtonActivate = $line[3][0];
            $DelButtonAction = $line[3][1];
            
            $value .='<tr>';
            if ($this->asIdCol) {
                $value .= '<td>'.$this->actualIndex.'</td>';
                $this->actualIndex++;
            }
            foreach ($data as $val) {
                $value .= '<td>'.$val.'</td>';
            }
            $value .='</tr>';
            
        }
        $value .='</tbody>';
        $this->table .= $value;
    }

    private function endTable()
    {
        ob_start();
        ?>
        </table>
        </div>
        </div>
        <?php
        $this->table .= ob_get_clean(); 
    }

    public function GenerateScript() {
        ob_start();
        ?>
        <script>
        $(document).ready( function () {
            $('#<?=$this->tableName?>').DataTable();
        } );
        </script>
        <?php
        return ob_get_clean(); 
    }
    public function Generate() {
        $this->createLines();
        $this->endTable();
        return $this->table;
    }
}