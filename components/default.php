<?php
require_once "class/DatabaseClass.php";
$db = new DatabaseClass();
$orders = $db->qty("SELECT COUNT(*) FROM tb_order WHERE pay_status = 0 ")->fetch_array()[0];
$mem = $db->qty("SELECT COUNT(*) FROM tb_member WHERE mem_status = 1  ")->fetch_array()[0];
$pro = $db->qty("SELECT COUNT(*) FROM tb_product")->fetch_array()[0];
$pm = $db->qty("SELECT COUNT(*) FROM tb_promotion")->fetch_array()[0];
$sum_order = $db->qty("SELECT SUM(order_total) , MONTH(order_date) FROM `tb_order` GROUP BY MONTH(order_date) ")->fetch_all();
$money_m = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

for ($i = 0; $i < count($sum_order); $i++) {
    $money_m[$sum_order[$i][1] - 1] = $sum_order[$i][0];
}

?>
<!-- Main content -->

<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="flex justify-between p-5 ">
        <!----card-->
        <div class=" p-3 rounded-lg bg-white flex ">
            <!-- small box -->
            <div class="p-2">
                <h1 class="text-lg ">ออเดอร์</h1>
                <h1 class="text-4xl text-center font-bold"><?php echo number_format($orders); ?></h1>
            </div>
            <div class="p-2">
                <i class="fas fa-shopping-basket  text-cyan-500 text-7xl"></i>
            </div>
        </div>
        <div class=" p-3 rounded-lg bg-white flex ">
            <!-- small box -->
            <div class="p-2">
                <h1 class="text-lg ">สมาชิก</h1>
                <h1 class="text-4xl text-center font-bold"><?php echo number_format($mem); ?></h1>
            </div>
            <div class="p-2"><i class="fas fa-user-friends text-7xl text-green-500"></i>
            </div>
        </div>
        <div class=" p-3 rounded-lg bg-white flex ">
            <!-- small box -->
            <div class="p-2">
                <h1 class="text-lg ">สินค้า</h1>
                <h1 class="text-4xl text-center font-bold"><?php echo number_format($pro); ?></h1>
            </div>
            <div class="p-2">
                <i class="fas fa-boxes text-yellow-500 text-7xl"></i>
            </div>
        </div>

        <div class=" p-3 rounded-lg bg-white flex ">
            <!-- small box -->
            <div class="p-2">
                <h1 class="text-lg ">โปรโมชั่น</h1>
                <h1 class="text-4xl text-center font-bold"><?php echo $pm; ?></h1>
            </div>
            <div class="p-2">
                <i class="fas fa-tag text-7xl text-red-500"></i>
            </div>
        </div>


    </div>
    <div class="p-5 my-5 bg-white">
        <canvas id="line"></canvas>
    </div>

    <div class="p-5 my-5 bg-white">
        <canvas id="bar"></canvas>
    </div>


</div><!-- /.container-fluid -->

<!-- /.content -->
<script type="text/javascript">
    const line = document.getElementById("line");
    const myChart_line = new Chart(line, {
        type: "line",
        data: {
            labels: [
                "มกราคม",
                "กุมภาพันธ์",
                "มีนาคม",
                "เมษายน",
                "พฤษภาคม",
                "มิถุนายน",
                "กรกฏาคม",
                "สิงหาคม",
                "กันยายน",
                "ตุลาคม",
                "พฤศจิกายน",
                "ธันวาคม",
            ],
            datasets: [{
                label: "ยอดขาย ICECREAM ประจำปี <?php echo (int)date('Y') + 543 ?>",
                data: [<?php
                        print_r(implode(",", $money_m));
                        ?>],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderWidth: 1,
            }, ],
        },
        options: {
            responsive: true,
            plugins: {},
            scales: {
                y: {
                    // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                    suggestedMin: 30,

                    // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                    suggestedMax: 50,
                },
            },
        },
    });

    const bar = document.getElementById("bar");
    const myChart_bar = new Chart(bar, {
        type: "bar",
        data: {
            labels: [
                "มกราคม",
                "กุมภาพันธ์",
                "มีนาคม",
                "เมษายน",
                "พฤษภาคม",
                "มิถุนายน",
                "กรกฏาคม",
                "สิงหาคม",
                "กันยายน",
                "ตุลาคม",
                "พฤศจิกายน",
                "ธันวาคม",
            ],
            datasets: [{
                label: "ยอดขาย ICECREAM <?php echo (int)date('Y') + 543 ?>",
                data: [<?php
                        print_r(implode(",", $money_m));
                        ?>],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderWidth: 1,
            }, ],
        },
        options: {
            responsive: true,
            plugins: {},
            scales: {
                y: {
                    // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                    suggestedMin: 30,

                    // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                    suggestedMax: 50,
                },
            },
        },
    });
</script>