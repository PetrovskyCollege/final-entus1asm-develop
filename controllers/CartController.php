<?php

namespace app\controllers;
use app\models\Good;
use app\models\Cart;
use Yii;
use yii\helpers\Url;
use app\models\Order;
use app\models\OrderGood;
use yii\web\Controller;

class CartController extends Controller
{

    public function  actionOrder() {
        $session = Yii::$app->session;
        $session->open();
//        if ($session['cart.totalSum']) {
//            return Yii::$app->response->redirect(Url::to('/'));
//        }
        $order = new Order();
        if  ($order->load(Yii::$app->request->post())) {
            $order->date = date('Y-m-d H:i:s');
            $order->sum = $session['cart.totalSum'];
            if ($order->save()) {
                $currentId = $order->id;
                $this->saveOrderInfo($session['cart'], $currentId);
                Yii::$app->mailer->compose()
                    ->setFrom(['denisarsenev15112@gmail.com' => 'test test'])
                    ->setTo($order->email)
                    ->setSubject('Ваш заказ принят')
                    ->setTextBody('Текст вашего сообщения здесь')
                    ->send();
                $session->remove('cart');
                $session->remove('cart.totalQuantity');
                $session->remove('cart.totalSum');
                return $this->render('success', compact('session', 'currentId'));
            }
        }
        $this->layout = 'empty-layout';
        return $this->render('order', compact( 'session', 'order'));
    }

    protected function saveOrderInfo($goods, $orderId) {
        foreach ($goods as $id=>$good) {
            $orderInfo = new OrderGood();
            $orderInfo->order_id = $orderId;
            $orderInfo->product_id = $id;
            $orderInfo->name = $good['name'];
            $orderInfo->price = $good['price'];
            $orderInfo->quantity = $good['goodQuantity'];
            $orderInfo->sum = $good['price']*$good['goodQuantity'];
            $orderInfo->save();
        }
    }

    public function actionDelete($id) {
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart -> recalcCart($id);
        return $this->renderPartial('cart', compact( 'session'));
    }
    public function actionClear() {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.totalQuantity');
        $session->remove('cart.totalSum');
        return $this->renderPartial('cart', compact( 'session'));
    }

    public function actionOpen() {
        $session = Yii::$app->session;
        $session->open();
        return $this->renderPartial('cart', compact( 'session'));
    }

    public function actionAdd($name) {
        $good = new Good();
        $good = $good->getOneGood($name);
        $session = Yii::$app->session;
        $session->open();
        // $session->remove('cart');
        $cart = new Cart();
        $cart->addToCart($good);
    return $this->renderPartial('cart', compact('good', 'session'));
    }

}