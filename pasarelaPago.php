<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.paypal.com/sdk/js?client-id=AVcdoQqyzvX83xtbJtGUqCJaqh1SUGhMi63uaeAGR7teyF9-gusfwyrtFbsICYJpJIeB0Pk0xbCzaKlO&currency=EUR"></script>
    <title>Document</title>
</head>
<body>

    <div id="paypal-button-container"></div>
<script>
            paypal.Buttons({
                style:{
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function(data,actions){
                    return actions.order.create({
                        purchase_units:[{
                            amount: {
                                value: 100
                            }
                        }]
                    });
                },

                onApprove: function(data, actions){
                    actions.order.capture().then(function(detalles){
                        window.location.href="servicesContra.php"; // Verifica esta línea
                    });
                },

                onCancel: function(data){
                    alert("Pago cancelado");
                    console.log(data);
                }
            }).render('#paypal-button-container');
    </script>
</body>
</html>