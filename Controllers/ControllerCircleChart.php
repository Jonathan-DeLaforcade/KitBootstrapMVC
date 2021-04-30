<?php


// $Chart = new LineChart("lineChart1",array("sep","oct","nov","dec","jan","feb"));
// $Chart->AddLine("test1",array(1,2,3,4,5,6),'rgba(255, 0, 0, 0.2)');
// $Chart->AddLine("test2",array(5,6,7,8,9,10),'rgba(0, 255, 0, 0.2)');
// $Chart->AddLine("test3",array(5,2,6,5,8,4),'rgba(0, 0, 255, 0.2)');
// $Chart->AddLine("test4",array(8,6,2,10,15,1));
/*
ob_start();

$number = array(1,5,15,25,50);
?>
<script>
    var circle = document.getElementById("CircleJS");
    var circleColor = getRandomColor();
    var Number = circle.getAttribute("Number");
    console.log(Number);
    new Chart(circle , {
    type: 'doughnut',
    data: {
        labels: ["tructruc"],
        datasets: [{
        data: ["<?php echo implode('","', $number); ?>"],
        backgroundColor: [circleColor],
        hoverBackgroundColor: [circleColor],
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
$CircleChartJS = ob_get_clean();
*/


$CircleChart = new CircleChart("Circle1");
$CircleChart->addData("test",5);
$CircleChart->addData("test",5);
$CircleChart->addData("test",5);
$CircleChart->addData("test",5);

$CircleChartPage = new Controller() ;
$CircleChartPage->pageName = "CircleChart";
$CircleChartPage->scriptPerso = $CircleChart->GenerateJS();
$CircleChartPage->customVars["Circle"] = $CircleChart->GenerateHTML();
//$ChartPage->customVars["Circle"] = $CircleChart->GenerateHTML();
$CircleChartPage->generate();