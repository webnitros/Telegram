<?php
/** @var \TelegramManager\Hook $Hook */
/* @var msOrder $msOrder */
/* @var msOrderAddress $Address */
/* @var msOrderProduct[] $Products */
/* @var msDelivery $Delivery */
/* @var msPayment $Payment */

$Address = $msOrder->getOne('Address');
$Products = $msOrder->getMany('Products');
$Delivery = $msOrder->getOne('Delivery');
$Payment = $msOrder->getOne('Payment');

// Список товаров в заказе
$i = 0;
$products = [];
foreach ($Products as $product) {
    $i++;
    $options = $product->get('options');
    $products[] = "{$i}. {$product->name} {$options['size']} *({$product->count} шт.)* - *" . $product->get('cost') . '* руб.';
}
$products = implode(PHP_EOL, $products);

$delivery_cost = $msOrder->get('delivery_cost');

// Текст сообщения
$message = "
------------------------        
------------------------        
------------------------        
*Новый заказ #{$msOrder->num}*

Способ оплаты: {$Payment->name}
Способ доставки: {$Delivery->name}
Стоимость доставки: {$delivery_cost} р.
Стоимость заказа: {$msOrder->cart_cost} р.
Общая сумма к оплате {$msOrder->cost} р.

*Заказанная продукция*
-----
{$products}
-----

*Контакты*
Телефон: {$Address->phone}
Получатель: {$Address->receiver}
Улица: {$Address->street}
Здание: {$Address->building}
Кв/Офис: {$Address->room}
Метро: {$Address->metro}
        ";

if (!empty($Address->comment)) {
    $message .= "Комментарий:
-----
{$Address->comment}
-----";
}

// Отправляет сообщение пользователю
$Hook->user()->message($message);
