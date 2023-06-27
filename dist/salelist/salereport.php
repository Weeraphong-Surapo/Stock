<?php
$all_product = $con->query("SELECT * FROM tb_productlist");
$array = array();
foreach ($all_product as $row) {
    $name = $row['pl_name_product'];
    array_push($array, $name);
}

$array_price = array();
$price = 0;

// print_r($array_qty);
?>
<div class="portlet-body">
    <div id="apexchart-4"></div>
</div>
<div class="portlet-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataAllProduct">
            <thead>
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนการขาย</th>
                    <th>ขายใด้</th>
                    <th>ส่วนลด/บาท</th>
                    <th>รายรับ/บาท</th>
                    <th>ต้นทุน/บาท</th>
                    <th>กำไร/ขาดทุน</th>
                    <th>ROI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $all_product_report = $con->query("SELECT * FROM tb_productlist");
                foreach ($all_product_report as $row) :
                    $sum_price = $con->query("SELECT sum(total_price) as total_prices FROM tb_order_product WHERE product_id = '$row[id]'");
                    $total_price = $sum_price->fetch_array();
                    $check = $con->query("SELECT count(order_id) as qty FROM tb_order_product WHERE product_id = '$row[id]'");
                    $discount = 0;
                    if ($check->num_rows >= 1) {
                        $count_qty = $check->fetch_array();
                        $discount = $con->query("SELECT qty,discount,sum_total_discount,cost,total_price FROM tb_order_product WHERE product_id = '$row[id]'");
                        $r_discount = $discount->fetch_array();
                        if($discount->num_rows >=1){
                            $sum_qty = $con->query("SELECT sum(qty) as sum_qty FROM tb_order_product WHERE product_id = '$row[id]'");
                            $row_sum_qty = $sum_qty->fetch_array();
                            $qty = $row_sum_qty['sum_qty'];
                            $discount = $r_discount['discount'];
                            $sum_cost = $r_discount['cost'] * $qty;
                            $sum_total = $r_discount['sum_total_discount'] * $qty;
                        }else{
                            $qty = 0;
                            $discount = 0 ;
                            $sum_cost = 0;
                            $sum_total= 0;
                        }
                        $cost = $con->query("SELECT sum(cost) as costs FROM tb_order_product WHERE product_id = '$row[id]'");
                        $r_cost = $cost->fetch_array();

        

                        $profix = $sum_total - $sum_cost;
                        if ($profix > 0 && $sum_cost > 0) {
                            $roi = ($profix / $sum_cost) *100 ;
                        } else {
                            $roi = 0;
                        }
                        array_push($array_price, $sum_total);
                    } else {
                        $qty = 0;
                        $discount = 0;
                        $sum_cost = 0;
                        $sum_total = 0;
                        array_push($array_price, $sum_total);
                    }

                ?>
                    <tr>
                        <td><?= $row['pl_product_id']; ?></td>
                        <td><?= $row['pl_name_product']; ?></td>
                        <td><?= $qty; ?></td>
                        <td><?= number_format($total_price['total_prices']); ?></td>
                        <td><?= number_format($discount); ?></td>
                        <td><?= number_format($sum_total); ?></td>
                        <td><?= number_format($sum_cost); ?></td>
                        <td><?= number_format($profix) ?></td>
                        <td><?= number_format($roi, 2, '.', ',') ?> %</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    "use strict";

    function _typeof(obj) {
        "@babel/helpers - typeof";
        return (
            (_typeof =
                "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?
                function(obj) {
                    return typeof obj;
                } :
                function(obj) {
                    return obj &&
                        "function" == typeof Symbol &&
                        obj.constructor === Symbol &&
                        obj !== Symbol.prototype ?
                        "symbol" :
                        typeof obj;
                }),
            _typeof(obj)
        );
    }

    function ownKeys(object, enumerableOnly) {
        var keys = Object.keys(object);
        if (Object.getOwnPropertySymbols) {
            var symbols = Object.getOwnPropertySymbols(object);
            enumerableOnly &&
                (symbols = symbols.filter(function(sym) {
                    return Object.getOwnPropertyDescriptor(object, sym).enumerable;
                })),
                keys.push.apply(keys, symbols);
        }
        return keys;
    }

    function _objectSpread(target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = null != arguments[i] ? arguments[i] : {};
            i % 2 ?
                ownKeys(Object(source), !0).forEach(function(key) {
                    _defineProperty(target, key, source[key]);
                }) :
                Object.getOwnPropertyDescriptors ?
                Object.defineProperties(
                    target,
                    Object.getOwnPropertyDescriptors(source)
                ) :
                ownKeys(Object(source)).forEach(function(key) {
                    Object.defineProperty(
                        target,
                        key,
                        Object.getOwnPropertyDescriptor(source, key)
                    );
                });
        }
        return target;
    }

    function _defineProperty(obj, key, value) {
        key = _toPropertyKey(key);
        if (key in obj) {
            Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
            });
        } else {
            obj[key] = value;
        }
        return obj;
    }

    function _toPropertyKey(arg) {
        var key = _toPrimitive(arg, "string");
        return _typeof(key) === "symbol" ? key : String(key);
    }

    function _toPrimitive(input, hint) {
        if (_typeof(input) !== "object" || input === null) return input;
        var prim = input[Symbol.toPrimitive];
        if (prim !== undefined) {
            var res = prim.call(input, hint || "default");
            if (_typeof(res) !== "object") return res;
            throw new TypeError("@@toPrimitive must return a primitive value.");
        }
        return (hint === "string" ? String : Number)(input);
    }
    $(function() {
        var isDarkDefault = localStorage.getItem("theme-variant") == "dark";
        var themeVariantDefault = isDarkDefault ? "dark" : "light";
        var colors = {
            white: "#fff",
            black: "#424242"
        };
        var themeOptions = {
            light: {
                theme: {
                    mode: "light",
                    palette: "palette1"
                }
            },
            dark: {
                theme: {
                    mode: "dark",
                    palette: "palette1"
                }
            },
        };
        var counter = 1;
        var categories = <?= json_encode($array) ?>;

        categories = categories.map(function(category) {
            return counter++ + '. ' + category;
        });

        var chart4 = new ApexCharts(
            document.querySelector("#apexchart-4"),
            _objectSpread(
                _objectSpread({}, themeOptions[themeVariantDefault]), {}, {
                    series: [{
                        name: 'รายรับ',
                        data: [<?= implode(',', $array_price) ?>]
                    }, ],
                    chart: {
                        type: "bar",
                        height: 350,
                        background: "transparent"
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    yaxis: {
                        forceNiceScale: true,
                        labels: {
                            formatter: function(value) {
                                return Math.round(value);
                            }
                        }
                    },
                    xaxis: {
                        categories: categories,
                    },
                    tooltip: {
                        enabled: true,
                        y: {
                            formatter: function(val) {
                                return "฿" + val.toFixed();
                            }
                        },
                    }
                }
            )
        );

        chart4.render();
        $("#theme-toggle").on("click", function() {
            var isDark = $("html").attr("data-theme") == "dark";
            var themeVariant = isDark ? "dark" : "light";
            chart1.updateOptions(
                _objectSpread(
                    _objectSpread({}, themeOptions[themeVariant]), {}, {
                        markers: {
                            strokeColors: isDark ? colors.black : colors.white
                        }
                    }
                )
            );
            chart2.updateOptions(
                _objectSpread(
                    _objectSpread({}, themeOptions[themeVariant]), {}, {
                        markers: {
                            strokeColors: isDark ? colors.black : colors.white
                        }
                    }
                )
            );
            chart3.updateOptions(themeOptions[themeVariant]);
            chart4.updateOptions(themeOptions[themeVariant]);
            chart5.updateOptions(
                _objectSpread(
                    _objectSpread({}, themeOptions[themeVariant]), {}, {
                        markers: {
                            strokeColors: isDark ? colors.black : colors.white
                        }
                    }
                )
            );
            chart6.updateOptions(themeOptions[themeVariant]);
            chart7.updateOptions(themeOptions[themeVariant]);
            chart8.updateOptions(themeOptions[themeVariant]);
            chart9.updateOptions(
                _objectSpread(
                    _objectSpread({}, themeOptions[themeVariant]), {}, {
                        markers: {
                            strokeColors: isDark ? colors.black : colors.white
                        }
                    }
                )
            );
            chart10.updateOptions(
                _objectSpread(
                    _objectSpread({}, themeOptions[themeVariant]), {}, {
                        markers: {
                            strokeColors: isDark ? colors.black : colors.white
                        }
                    }
                )
            );
        });
    });

    var table = $('#dataAllProduct').DataTable();
</script>