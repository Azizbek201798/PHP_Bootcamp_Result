<?php

$matn = "ChatGPT - Open AI tomonidan yaratilgan yuqori qobiliyatli, foydalanuvchi soÊ»rovlariga javob berish uchun katta hajmdagi maÊ¼lumotlarni qayta ishlash va 
tahlil qilishga moâ€˜ljallangan sun'iy intellekt dasturi. ChatGPT inson tilini og'zaki va yozma ravishda tushuna oladi. ChatGPT matnlar bilan ishlaydi yaâ€™ni 
unga kirtiladigan soâ€˜rovlarni matn shaklda qabul qiladi va javob qaytaradi. U OpenAI vositasi bo'lgani uchun ChatGPT rasm generatsiya qiluvchi DALL-E hamda 
video generatsiya qiluvchi Sora kabi boshqa sunâ€™iy intellektlar bilan muammosiz birlashadi. ChatGPT bepul yoki pulli taâ€™rifdan foydalanayotganingizga qarab 
GPT-3.5 yoki GPT-4 da ishlaydi.";

function Replace_and_Count($matn){

    $newMatn = str_replace("ChatGPT","GeminAI",$matn);
    echo $newMatn;
    echo "\n\nChatGPT so'zi " . substr_count($matn,"ChatGPT") . " marotaba o'zgardi!\n";

}

// O'rin almashtiruvchi va o'zgarishlarni sanovchi funksiya!
Replace_and_Count($matn);

?>