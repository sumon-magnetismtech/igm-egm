<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Bengali Forwarding Letter </title>
    <style>
        body{
            margin: 70px 20px 20px 40px;
            font-size:16px;
            font-family: 'examplefont', sans-serif;
            line-height: 20px;
        }
        body p{margin-top: 1px;margin-bottom: 5px;}
        span.EngFont{
            font-family: sans-serif;
            font-size:14px;
            font-weight:bold;
        }
        .overFlow{overflow: hidden;}

        .textUpper{text-transform: uppercase;}
        .textCenter{text-align: center;}
        .textRight{text-align:right;}
        .pullLeft{float:left;width:55%;display: block;}
        .pullRight{float:right;width: 35%;display: block;}
        .pullLeft, .pullRight{margin-top: 10px;margin-bottom: 10px;}
        .mrTB{margin-top: 15px; margin-bottom: 15px}
    </style>
</head>
<body>

    <header class="textCenter" style="margin-top: 150px">
        <h2> চট্টগ্রাম বন্দর কর্তৃপক্ষ<br> টার্মিনাল ম্যানেজার এর দপ্তর। </h2>
    </header>

    <p> নং: টি এম /আইসিডি/ভরা/২০২০ </p>

    <div class="addressArea mrTB">
        <div class="mrTB">
            <p> বরাবরে </p>
            <p>সহকারী পরিবহন কর্মকর্তা (কন্ট্রোল)  </p>
            <p>টাওয়ার ভবন/চবক </p>
            <p>চট্টগ্রাম।  </p>
        </div>
    </div> <!-- end addressArea -->

    <p class="mrTB"> বিষয়: জাহাজ এমভি <span class="EngFont"> {{$permissionData->feederVessel}}</span> আমদানী পালা নং: <span class="EngFont">{{$permissionData->rotationNo}}</span>
        আগমন তারিখ <span class="EngFont">
        @if(!empty($permissionData->arrivalDate))
            {{date('m-d-yy', strtotime($permissionData->arrivalDate))}}
        @else
            _________________
        @endif
        </span>
        এর অধীনে আনীত
        <span class="EngFont"> </span>
        @php $type =array() @endphp
        @foreach($blcontainers as $key=>$container)
            @php  $type[$key] = $container->type; @endphp
        @endforeach
        @php $types = array_count_values($type);  @endphp
        @foreach($types as $type=>$key)
            <span class="EngFont">  {{$key}} X {{$type}}</span> (লোড),
        @endforeach
             এফসিএল কন্টেইনার নং সংযুক্ত তালিকা মতে বন্দরের কন্টেইনার আইসিডি ইয়ার্ড থেকে ট্রেনযোগে ঢাকা আইসিডিতে প্রেরণ প্রসঙ্গে।
    </p><br>
    <p class="mrTB">
        সূত্র: (১) কিউসি লজিস্টিক্স লি: চট্টগ্রাম এর পত্র নং-কিউ সি এম এল/১৫/তারিখ: <span class="EngFont"> {{date('d-m-yy',strtotime(now()))}}</span> ইং
    </p><br>

    <div class="contentArea overFlow" style="text-align: justify">
        <p class="mrTB">
            উপরোক্ত বিষয়ে জাহাজ প্রতিনিধির সূত্রোক্ত আবেদন এর প্রেক্ষিতে বর্ণিত জাহাজ যোগে আনীত
            <strong>
                @foreach($types as $type=>$key)
                    <span class="EngFont">  {{$key}} X {{$type}}</span> (লোড),
                @endforeach
                = <span class="EngFont">{{count($blcontainers)}}</span>টি (এফসিএল/) </strong>
            আইসিডি বাউন্ড কন্টেইনারের জন্য কাস্টমস কর্তৃক গৃহীত আইসিডি মেনিফেস্ট এর ভিত্তিতে সংযুক্ত তালিকা অনুযায়ী এবং পরবর্তী অত্র দপ্তর থেকে প্রদত্ত এসাইনমেন্ট মোতাবেক কন্টেইনার গুলি বন্দরের আইসিডি ইয়ার্ড থেকে ট্রেনযোগে ঢাকা আইসিডিতে প্রেরণের জন্য বলা গেল।
        </p><br><br>

        <p class="textRight mrTB">টার্মিনাল অফিসার (কন্ট্রোল) <br> চট্টগ্রাম বন্দর কর্তৃপক্ষ</p> <br>

        <p class="mrTB">অনুলিপি: অবগতি ও প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য  </p>
        <p>১) মেসার্স কিউসি লজিস্টিক্স লিমিটেড চট্টগ্রাম।  </p>
        <p>২) এরিয়া অপারেটিং ম্যানেজার, বাংলাদেশ রেলওয়ে টাওয়ার ভবন/ চ ব ক।  </p>
        <p>৩) পরিবহন পরিদর্শক ইয়ার্ড/সি,সি,টি/আইসিডি/ চ ব ক এর অবগতি এবং কন্টেইনারগুলো ঢাকা আইসিডিতে প্রেরণের পর ১টি তালিকা টিআই কন্টেইনার বিলিং শাখা বরাবরে প্রেরণ করতে বলা গেল। কন্টেইনারগুলো বাস্তবে ওভার ওয়েট/ওভার হাইট পাওয়া গেলে তাও জানাতে বলা গেল।</p>
        <p>৪) পরিবহন পরিদর্শক বিলিং শাখা টার্মিনাল ভবন চ ব ক এর অবগতি এব কন্টেইনারগুলোর বন্দর মাশুল বাবদ লিফট অন, স্টোররেন্ট, রিভার ডিউজ, ভ্যাটসহ অন্যান্য চার্জ টেরিফ অনুযায়ী শিপিং এজেন্টের আর, ডি একাউন্ট নং-৬৩২৩৯০০৩ থেকে বন্দরের যাবতীয় চার্জ আদায় করতে বলা গেল।</p>
        <p>ইনচার্জ (গুডস-৫) টাওয়ার ভবন / চ ব ক এর অবগতি ও কন্টেইনার /গুলি পরিবহন বাবদ রেলওয়ের ফ্রেইট শিপিং এজেন্টের আর, ডি একাউন্ট নং-৬৩৯৫১০০৫ থেকে আদায় সহ কন্টেইনারটি /গুলো ঢাকা আইসিডিতে প্রেরণের জন্য বুক করার নিমিত্তে এতদসংগে আইজিএম এবং কন্টেইনারের তালিকা প্রেরণ করা গেল।  </p><br><br>

        <p class="textRight mrTB">টার্মিনাল অফিসার (কন্ট্রোল) <br> চট্টগ্রাম বন্দর কর্তৃপক্ষ</p>
    </div>  <!-- end contentArea -->
</body>
</html>
