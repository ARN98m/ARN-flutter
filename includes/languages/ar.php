<?php
function lang($phrase)
{
    static $lang = array(
        'homePage'    =>  'صفحة مشترياتي',
        'SalesPage'    =>  'صفحة مبيعاتي',
        'manage'    =>  'ادارة',
        'historyPage'    =>  'التاريخ',
        'category'    =>  'الصنف',
        'My stats'    =>  'منحنى ارباحي',
        'product'    =>  'المنتج',
        'chose product' => 'اختر المنتج',
        'chose category' => 'اختر الصنف',
        'not sale' => 'ليس للبيع',
        'for sale' => 'للبيع',
        'status' => 'الحالة',
        "id" => "الترتيب",
        "price" => "السعر",
        "price_of_product"=>"سعرالمنتج",
        "selling_price"=>"سعر بيع المنتج",
        "quantity" => "الكمية",
        "nb_pieces" => "عدد القطع",
        "price Total" => "السعر الاجمالي",
        "date" => "التاريخ",
        "Nb Of Products" => "عدد المنتجات",
        "view" => "المزيد",
        "delete" => "حذف",
        "edit/delete" => "تعديل/حذف",
        "add" => "اضافة",
        "update" => "تحديث",
        "shop" => "شراء",
        "logout" => "تسجيل الخروج",
        "p-hold" => ["quant" => "ادخل الكمية", "product" => "ادخل اسم المنتج", "price" => "خمسون الف (500)","nb_pieces"=>"ادخل عدد القطع","category"=>"ادخل الاصناف"],
        "desc page" => ["history Page" => "هذه الصفحة تحفض فيها كل من مشترياتي ومبيعاتي وارباحي", "manage" => "هذه الصفحة تقوم باضافة البضائع التي غالبا ستشتريها", "homePage" => "في هذه الصفحة تقوم  بشراء ماتاجه" ,"SalesPage"=>"في هذه الصفحة تقوم بحفض ما تم بيعه"]
    );
    return $lang[$phrase];
}
