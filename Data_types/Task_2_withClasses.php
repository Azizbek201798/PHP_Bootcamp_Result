<?php

$matn = "ChatGPT - Open AI tomonidan yaratilgan yuqori qobiliyatli, foydalanuvchi soÊ»rovlariga javob berish uchun katta hajmdagi maÊ¼lumotlarni qayta ishlash va 
tahlil qilishga moâ€˜ljallangan sun'iy intellekt dasturi. ChatGPT inson tilini og'zaki va yozma ravishda tushuna oladi. ChatGPT matnlar bilan ishlaydi yaâ€™ni 
unga kirtiladigan soâ€˜rovlarni matn shaklda qabul qiladi va javob qaytaradi. U OpenAI vositasi bo'lgani uchun ChatGPT rasm generatsiya qiluvchi DALL-E hamda 
video generatsiya qiluvchi Sora kabi boshqa sunâ€™iy intellektlar bilan muammosiz birlashadi. ChatGPT bepul yoki pulli taâ€™rifdan foydalanayotganingizga qarab 
GPT-3.5 yoki GPT-4 da ishlaydi.";

class Matn{
    public $matn;
    public $newMatn = "";

    public function __construct($matn){
        $this->matn = $matn;
    }

    public function Replace($matn){
        $this->newMatn = str_replace("ChatGPT","GamingAI",$matn);
        return $this->newMatn;
    }

    public function CountChanges($matn){
        return substr_count($matn,"ChatGPT");
    }
}

// Class dan obyekt olish;
$text = new Matn($matn);

echo $text->Replace($matn) . PHP_EOL;
echo "\nChatGPT so'zi " . $text->CountChanges($matn) . " marotaba o'zgartirildi." . PHP_EOL;

// Natijada faqatgina ChatGPT so'zi nechi marotaba o'zgartirilgani emas berilgan matnni o'zgargandagi holatini ko'rsatish uchun yangi matn ham chiqartirildi.

?>