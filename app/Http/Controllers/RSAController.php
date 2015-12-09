<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use Psy\TabCompletion\Matcher\KeywordsMatcher;

class RSAController extends Controller {
    public static function Test(Request $request){
        $request->session()->regenerate();
        //Session::flush();
        //$data = ConfigController::GetAllConfig();
        //$crypt = new mycrypt();
        $con = 'bmtrgPKaToAus8LSTnJVVJeLeeTzWhUf2x2+KlMDhQGXn4nzaOki6GJ6gJjfnxslFiHwq2CWdgCs8rYDWAXRVB8K+J/TrgaTluwogAb2dfmMT/+um2aLNgL35MsJcUsNKeibygWVGqKxq3KeDYezsxEHRc/EW/3apybb3n1yPns=XU/f+kk+fPQx5+vVb0hq+64bLz5tCsyaQ5D31SppOQisDTeXPGIvQ9kTX7pbM/U2rCo+g7/2hmfLjF0lfJl4lNf+0rFgBMK/HPJCpUvYLT4Xa+dv4jI8oYrNeiD/Vr2a/KKDwf+PVBGCC3cZPMZSwii5XI69QWIof2zJb4uSJNM=AAqFxTBz2MHQ0N1dXma4zkrRIVeXz7PwuJK91aigmQqjQ/rw1w68UqecZWvJFu/Z6TXgBLOEvpXvDJr7ZV1C+rFsqPYgkIeGrbYpJXYcs7mQqDdQZQkQNkmDUHKskF7Dfa/Zqh+irWk6KraukOPp0X9ofPhFJOqctyc5kttS3Vw=dS/c+cTCDgc06wLf18V6mm0bODfC2vQlmtpbriFXFgW4FXyHp36zYosbUE/oqY+TVstZLl20lZFUh+GhtBCCl+6ykb/uLnuN6rk5uxv8oPwOFIRcKgFwaeh5Jtj3Q51uV4JWHin6YSylN7YxGC7kIqW6NOpQIUgF1gWIq5KiovE=RELBKCu+/dN77N4+12yoRnEYxHNy1l5csX6ghFmvfySDs6W3uNeD59ux/CjAXsSz9fgaphzLXkzZSMKNPMMLDpvArvYZl02QjFZx+hDCAuSSINHlRLVw/PZhHQp0DpsmHu0O5vNoqs7R3k3xqaORcRIJ5vaUS6u7WhF4fI36Jk8=KBE5l0oQosGJ+4OJOTpOJ4zj22KsA8LRR4iwrKHROFtyMCm6yjmXCuWr3rPtp5anZ003Gu1Xy8nFvgDtNHJR6DACcc40vE2FT8BC+S2hwwg86C3h5Ob2ULJPlhkSsV70+2JdMO/EhBVyChk4tmeC+S59E90JugpcWEwAh6/GyfU=VCYL3FzYtsx11et3ZH9uBfXuvYDuttI13t6AUTuxHkikAaWRednx/wcSY4jeBMEBSSKdrfoLSxcA/4c7a11ud5CyqFUUl3bVipeB/y4Bts1EOrVJZB7WecClE3ivfh+iQEVZPef4unhVNtc0lMesJ1vejXl74qkBiVJOWuaBhso=GicOY8shjq3tGWeS8edWsgZU9yverXwk8VD7Q5b/THsrIiDBGkTMsPy7EJkXbz4x3Und2XfuO43qPaRw93PDtA6y7XUyjwKO3rk1cpv0poEQNt6fko9kTXBTFZAHT9YDoO4yOFuwSmDo1mN0z0ySZsdNM5cmM6aWzOW6Hruo7Kc=NN44jQMB7gb02XgdzQLiucQO1WhBCY5/Rpmt/jsiwfmR25cqonKHmsnhUD5oDbDQnPmE2iYRTWtzzPGhTx35zzylJZHoXbAJibZerbXR6Fsa3dvSMT8mRDJIQRngwpsArHs329ZwXxmWMgcYi/D2cDNTKEHdKfxytP0fZnpGwZs=Tnor6+JDY6C2G9L7Rnp9CtpAXYlOQJNvUkELmkpB7zrxpYKYJx1wvxOSx9uvBx/UGX1KDBJ6kK5zXXSUm1qO0znFaNsMSChNqMzZ0CrkozqTOkCYUX1bejAnu3TlgDJlCwJ5doGCPX0GQWiS138hWYe9g81SMyUCsoi84n0XdL0=ZSxcNc3Av+RZ0lVYRk8f/dqr21UsLtqTEWopA9xXGBVAOV9IwUEDbP13mE3Tl17wYt0k98Mpwi+GQ+rG1gs7EFus4XqDEQue6SgcbZfQgMm71HZYqRvHzM4++WiPgRBMQQCK8PuG3szFL0yojvSPqbR9K3QO7KK66KueDOdIhuM=E+8E23bb1/StmPO/CNDCYWqth39PD6RPsYQsPTV6FirVQtM8jVDn7V2iwSpngVeu+jGsFO6aAqAY5wlWwOWN9zzZQDOrESH2ZBHquRoeApLzwb164QBi+puUb0AQhnIsK2UNp1MpWn2SsbLZt6BeLzp97A240HxO97K45esWZRo=WVzr1cwkbkZPKiUW4NlT4qNWNj0hLbT3QJe+i4B8PDpTpVMDyX5GUApGkaVNguYY8uiiDI24U9prKC8luapDpG0CXsUUa/X0wXV/79uiVrg+HTdkQDyYeBgRwUJHtCpugoyJ8pt48f0Xv/ILp2w8C6/jDHg3zJ/c9oVUmiMllks=E+dOLS2Bs5zazuieFffCldaqLyK/GBYoyXDRGy2FuvE9m20FsDn6o00pf4LJkZBr5/yIUCKwm3TaFnt7R+S5yRoUeroeiI0C04F05+ihrO0OGHbkb66cqh4q3oWTlEqZj34LlxvZ5z2lhJejnCWd/j35kpKfOAo6ayk4sraKLxU=Y4nsYC7khl6BsWC/7QABhRezl09RZRLRvj4MSjbTxPHrp0FU+6xHlwhue+yxmU9dXDXSWZFpkOspL4ja2rqbljEE9GgPeAoSTHRwMwM5CeB/T4rvyH92fgwtlWfOVsneqI3QdmZJmoICxpY4mvCRuSB4w7TTVn8Zjh/5sqJBnak=dvu+FDfHg3oQoAbx5VzBXVD8XmwLmD3hMz63nEKPkhab6o8woEr9E9qboxYQAUw3GJA3IAA02e8N+Eg7flrokrbipvsl3QTvx5yZheO/kHDOnkZTsV9qPKDRa/nytIq+Fhb6IvsquSKQhT5ia2auJH4ncVN1l/s5/R1IZxg1J1k=VNhgA667pEqDXa1tqq5ArpSrEQk/xqtL5bdUSVg/rgTnc1iG/BwGO0gtHIGQ5J9vv+9mhrqxDVSAjPBvWvZyJx8crokT5p31lIaKkuoMi1po4AduD3cU5Cdd2T+LxYLeIkaDygtoDhgZb3CmdCaIVs4c9nqeX+hNIha1ijMmSEw=e3HnWkMShqXpYbnxUfMy4zO4Of4n38OESapBNrJISqntw3JBbubDHhpw8m6jPaPgarnEaQRwv4OKQnparUV7Bxlei39vSH8n5HoB1jf8X7qlIt/ia8whn2HWIwJfyIMoANuJuX3hcCWuxciZ8of8JWnUPLXaCNX5Lrh8qffgHRk=LV8/IItXxH5QoPi//9D3IG0vSfiUlWqTwHjv7x+ygPAKsjRoOK7tlqQ7vzjkeBrdcfFWhvt+oFX/77HTF/zwTc8Fa/Cn29Yqst4ahexsbxfzocjM4fCSOMVZ/cs8UeM81kSb4bksU16BJbdU4QZ5QnZLiHarIPgHl+a46Z2OPbY=FXTDXvWYIPDJrphODNsYSMV9OkExxN5zkOVGdn6Z65xy4ARBntvmA6FpdfZdlBebeRjbIs4hpA5fxnrz3onhwD57ULqrN7OMQ+/8/6R/fg+Ivm7S9pYaei/LkT+GRNx0WtWntAzn+ORy4gon1z6nCLR4OWobUuaOxAvKiLjAd4A=QKx9TuVDqF+vYU+nQm7mPBEMpiKU0LEEXnP48Q0IeHBo5W7B+v9X6T0oaOZe9G1iAd6lA+xUrSaq0OO/9+Dq7jtchmtBsBM/J+Zo2gChCsdrd5HSmp4eH9Gb14xWmviaLWQ4atoSmeK0Cep4RX5oKad++lXVztr8Qy7XvbixqSo=TfYt3JYurI6H9E/HoQshM8eRXsT7Ivcutm6/I5W17dEIMGmEete6iFoZAaaiyya0i0lJ4YS4giIw6IH0ObtLfDe1ATbmMzJcIe6dQVFgGviDEgrj+MURpMFU4fuOqcMKyWYAdGBC3to+RKRVLcSXchdZ9hmeOMLkB16g/dpFKx0=Khv+/BW1JBZUtQCjWG7cPRiCgrI6tNiAa2jx2m/HLm84DzzWzXo8fnxPp2V3bg0XW76pWbopkgn1kY8xiIhqBMOYuuCReC5ru4NhrxrcAA0OC+vfU4A66FduZ4aIfjIyKQh0T1rgbnMDmKxaKotSbo8P9I+fWjxVf1gZb2Xtqhs=EP31zycEbwXMe4fuT41xyuUP6a7U/RDNVujexSIKJH5JMvrAlalRToWmJOqje5KgLMurjyG9KlFKbs1tXYPTClTz8iD57jSF2KjzBSI9Fq/6xXvEiPDSyRDXDCv48jlUmDGUpx2q/VeT6f/ENOQgeiUoWPtpsPs1MHIqREck8yo=Vf2lOsmTwKQS6j1qtm/GO+sqrZFsyzfBax2R7sMBg36QeemxgJ8+YJZBVQdncRnE9gTRl0Y3yhNRuXiH+6F8I6geD05cUF1LPuZRILxhPq1qrwlRxjbgnp1VrtkWzArAEjiNYgqO/SD8VQsvt4XRjRDfibHYGOigx9lAqcwV+nk=L94S2M7n2EAROjXYb/3ErGOuDgTUp/i9qtXSA9vqKFqa8WTUkwZ89reIfTxJirELsm2WKRHPGYIGAPw1xMu1aVLP+d5hx9/iOdHlujOwX8CjQ4VkMcgCs5RVdbYjp1gmBE5+ecHeciM0cZa6o38MtGtTUZ92ABudIPosiZgBfe0=G7JYW4PwfOjJTPJBICUD0pL8ARJzbwZAkr4DKidSC2k2sosj91DDxaYQMqzxAhO2SCLSqqfT12u1FylYRyTtcnzEmoFHujKabTVVDQ39KQG+PHKakgR41Odwuda7sEvG/+30jOCkAdani+asaVktjCe95Xf3qE3CdjYmwzdjTfw=hHjG+QPcjsh/vVcfQadV14FlccFAwVkblRPAZrLcXrsDDXynwdWcPHgyMEp2De5KhHKeF2W/wDVZwdvWe0k7i7mgKldF34YebpziBvzLkf7Uwi2Pr4AlE46Mrlg2Ao6lBeFjAjwblvpnDG6soYAXMenEUU4HFnTdixi1X+seAUI=RG7HQPe1ukpMD+jtt6YX33HxiSTZY0rBMe518pY2aL5jRWqtv+pgC6C7k591iRMYF9fZ92WZ0q7QMaIKQ+tRFnQTkWiIma+YTuOjYIHppGESLtzjp3/vKJVWA6eXIBy6ebINr5yJly1zbjFLpjCJu+iK3ddaF8gNm2VUnZNnMhg=XNlSp7mC2WccWmCXYL7g78ToUnJw2fnWcSEPJO6U/Vwj9uo2eUuyoDfDOakm78hRxjHb5nB/x5azONQR53lVf3rc8lUJBXgmsjhF0DwFkERsokHLBb6zJj913wKeVHn4EVe5SVust8iCr6ZoxtE6uAuleVJBEahqKY715GmNPJU=Mus/aDd2oN8L5WipDN+RhdFezNjTUwRnlgfgDJDw/ejOT8g41XNXrsN3vqRHdsft6CiwR9eivYoJyiV9HwJxBZfRmYyHJrmy/THVqoXnEznisUhd4Dd+I98usDLCoJQ0+PvfSnOBj3TUCZY/P0/4tUD6rPy4xkvOrW9vcgcakBw=dvHvSmzEopFcYVqZd3ht0vjJb9vM+Dj8q9q3FaaKc1bvReud6qQeEgKdIAlKVnRBkeIERo17XDH3f5hMToZQnS4dm6ydKXHcnnHDv19u/JidYFCG/zWQ+XrF8Vk3Y+lof/txbw+y2V6eK7LcVjlCNVN+rxi7kYU/74v/b84ffy4=MdoaRtLhQ9j3qLd3wshZZ5ZwT+ZJLDD/piCAVOgfOSIkAv4TE1IWdJwKAPxr05BSxXa551Q4FixU0Hv5HtFg89AASXB/WM34pfwL/3pe3fFZImtCk6jzedBVvkOlhGeew6hdXVozzahCrCEA8v3lpG30MLkxUhGxFQ1B4/uaVVM=LT+9cUXTsR9q/9Ucm/C84lQOyvArbB2GEcPHyal6YNE5Ubv8JH9k9A82+8kVOfFGI/KceAFKbJPEXuVvdm09pT2bnR4pkpVP7Pt8jpa4n2C4asShBMavOA2N/r/oy3Ehtl2yVRb3hS3yDsTmCwsTBpu65DRcw6+h8REGASiWLbE=AbgB6eALXxexoVbFs18/rrKf5jJa62AKHkaZBb0DhH+Lm00KdK0od5Dfy6sTznUKYtIOxQ0gkDi2ltYUQ6Jz27p9pKNt2UNiNp7xuZP7IwV6xfgnMXIMBtCAAQzrWLU5uUCsZ7rsfSz6RUpWvsyn5Wxcxh4nOlSdB0eQnc+Y5mQ=fRM+81mDwwgw2V9ApjLeXdq7VenthojCZoh4vbTLtu4qhtWpP9/a41vWdlD8dQAAe6P/9x29is3s/zgdwlJCKhO/C6qs00h030KTN8aVgQbvqprDTEAsO7hzfFq9RdsFh80+V/At9JAW/kda/xdZJ5/jtGSBWLV3WSAKa6OW2ek=RTH/5ZzuSWZEOuk1QmcY0yinB4RNLntJG/b7Mu3X/+EwQ9lnfjkSWaSaZrM4kTDIhcn/OYMgiHGKSbgq9Jh9ryVGflgsY+wiMkv4/q+mOMUb0l7h6ohMABQ+IM1aKEvc7MIocbD1hkEIqBbrHFWe0tBEamFQ6xJPyAhSKRYOByI=Nd0i/pjdhAioBxxj9jP6Ldfx5/Kk+51v72V6Ll3FJW183k2KmBHgofR4JsMVq59zwhZy36+iwTonhityGZXK0mWQx7mQwW/gYAsU5VD4Xp9GGFPu4pSWRn/vzrD3B4PAA/Xo20sabsCQCswsCWuhv+REZpenkAtwtrRJLn8/hHA=DGreN+oYEhSjJzG/8MuCilfZuqDk8U7G+01ftDW4IChy6mg6+P98wKfqV2YY6SpCYKsKNXdHgO+6V7DciyDey/FoNVthcMKCE1aDx8WXiRmatZInd6W/ekj3cl9rZVSX8cJ2+HluWDBMmRbo2c3MeKxHnXhgxI2WB6kjFCAq8pE=DbHte07b4s6erDtcnNjGjNRZCXgJvmkoNcRydGvbk4DW6dX0AJmnMet6hOiC9WVfUKYAf0VH7saa4T5eIswuAIRFbScyNOyHINEgzSmgL9YuPVBbtat4B91u/g6P31RQ8Y2vjOJsF0PDgZO+y7BgVHyWkYObrnjzVHsgTTaYYrA=KYXvCckPLTmAz1jjW9HcymifVoDlZBD1sWuxvP4QrdxDQylbx93KmRQH5lndQh3PLdd3U5A3bDUTVcYiIQCFzeMQX1xYpBETgrwM78I6SdxDZ9I5A5VaRGM8zhQvsv2fToYfD4+r7+STLfhK7Wem4qaZQ2DiBimXw3fP+MwyzyQ=Ja0FklOit5gm6ayt53cwL6oIeh3KCvnkQSmYULfF0ruiSqnm0J5/c14kY/Wy2DmMs16yTjlrhXpFXLuXJLihiXEYK6FNgQSFLmerpL2icojoQ1RNHf0pd+gj1rEEaRQE8D/z1Ju8Nr4fkieRbx+e0EjqrLPGP4BoC28SwW9UGUI=Fng/bpGoTwkS4fka5ri5tKMxxf60zqPBHz9kfaXP2ZuxWCvb4r7A/o6Mxg80kQYSPmjReuVE8iHulfx/+I6gfMhRQGR5/vnhwG4ig52zTCYU+nsX+nj7I7qK+bywKqSO6uI5tCspA8HC8srz9eDu5JeOkagHhHry+DE5YANzPkE=c8p5vLT8cnhbk967u/5Hcxom6WXbIWSaPWhf2aYFzJCJhnCWZh0vQmSzlDV0adptn2/qkL/R+MTPv24A5KpopeZa2Mspko7wqev45qI8a9lLdrzh/Dll95YpWoP2oiLKMYGqH0tyk3ah/e+LdXupn99aocGkSCfuR4pY0ANlSag=KgF75sgCJ6lfB2pMLOSwMBN/89edLaeNhir3Z3uFMDXfv/YPTuglaYBgtrBDfawFHdsXATYpZnKLA/O5VNkvfcLBYYiSeI0xCzAxRzwTxlj6wpFcVE1YSKJ7U1LxmqF49mH/DF161NS0rRckNzNV2P2Kg5ooTjAEIVcZAtOmUXg=N74UCM7XSPcgq22lEh5jjSGWUBXPRWS/STkWvA59lD4qnJeEYDDQAeMDdmqdBMgP7MMl0hfCFW4I1phx1dcYqzwf0MIwD+LGzOAg5Bl5ZLnWmrW/XOkyvKiqxReG7JFlekJyByAP927NcPZw7cZI5VlOsmx5eaFJdqk7V5RscOo=V2kUfWgWZiObSwV0hKkTHrlrbdh+M7h70crqZG0uCtZzOUnreVA6DIQNVA3KmopJtW0Mpfx2S53ivItsepYebTLh2o8biOjueY841KwAC7Bc0CJYKpHKfF4FggkRm0RSYgXyrj6x5+Z1zgbZh8x5sAbQdW5kqjbINYsdQ92Ya3Q=MoQw4mHpTiLVQuW7L4pZP8ye/SsrrtlT2mBrUPCXD7r9eUVRq5toefKyuXHBqkqgGJCdwCwW4qB8DRw9wLxDunQVfUPP7Or4vZFkIo3Ts/5Ic4FpF7goXM97fhsqcgrt2GU8Dkyl5skvowW4kSZWgWoH/NCmYPOH1GtaNPh80nA=';
        //try{$crypt->encrypt($con);}catch (Exception $e){
            //echo $e->getMessage();
        //}
    }
    public static function KeyExchange($ClientKey,$request){
        $res = "";
        $crypt = new mycrypt();
        $FingerPrintObj=new FingerPrintResponse();
        $FingerPrintObj->VerifyString = str_random(32);
        try{
            $res = $crypt->encrypt(json_encode($FingerPrintObj),$ClientKey);
        }catch (\Exception $e){
            abort(404);
        }
        $fp = md5(time().str_random(16));
        $Session = new \App\Session();
        $Session->session_fp = $fp;
        $Session->user_pub = $ClientKey;
        $Session->verify_string = $FingerPrintObj->VerifyString;
        $Session->save();
        $request->session()->put('action','config');
        $request->session()->put('fp',$fp);
        $request->session()->put('provider',$crypt->friendlyname);
        //echo $request->session()->get('action');
        return $res;
    }
    public static function PushConfig($PostData,$request){
        $RequestJson = "";
        $crypt = new mycrypt();
        try{
            $RequestJson = $crypt->decrypt($PostData);
        }catch (\Exception $e){
            abort(404);
        }
        $Request = json_decode($RequestJson);
        $DecryptedString = $Request->decrypted_string;
        $VerifyString=$Request->verify_string;
        $fp = Session::get('fp');
        $Session = \App\Session::where('session_fp','=',$fp)->where('verify_string','=',$DecryptedString)->first();
        if($Session==null){
            abort(404);
        }
        $Configs=ConfigController::GetAllConfig();
        $result = new ConfigResponse();
        $result->VerifyString = $VerifyString;
        $result->Config = $Configs;
        $result->Provider = Session::get('provider');
        $res = "";
        try{
            $res = $crypt->encrypt(json_encode($result),$Session->user_pub);
        }catch (\Exception $e){
            abort(404);
        }
        $Session->delete();
        $request->session()->forget('action');
        $request->session()->forget('fp');
        $request->session()->forget('provider');
        return $res;
    }
    public static function Handle(Request $request){
        if($request->session()->has('action') && $request->session()->has('fp')){
            switch($request->session()->get('action')){
                case "config":
                    $PostData = file_get_contents("php://input");
                    return RSAController::PushConfig($PostData,$request);
                break;
                default:
                    $PostData = file_get_contents("php://input");
                    return RSAController::KeyExchange($PostData,$request);
            }
        }else{

            $PostData = file_get_contents("php://input");
            return RSAController::KeyExchange($PostData,$request);
        }
    }
}
class mycrypt {

    public $pubkey;
    public $privkey;
    public $friendlyname;

    function __construct() {
        $this->privkey = Config::find(1)->privatekey;
        $this->friendlyname = Config::find(1)->friendlyname;
    }

    public function encrypt($data,$Key) {
        $data = base64_encode($data);
        $encrypted = "";
        //把原始数据分段
        $len = 117;
        $m = strlen($data) / $len;

        if($m * $len!=strlen($data)){
            $m=$m+1;
        }

        for($i=0;$i<$m;$i++){
            $temp = "";
            $res = false;
            if ($i < $m - 1)
            {
                $temp =  substr($data,$i*$len,$len);
            }
            else{
                $temp = substr($data,$i*$len);
            }
            try{
                $res = openssl_public_encrypt($temp, $tempencrypted, $Key);
            }catch (\ErrorException $e){
                //echo $e->getMessage();
                throw new Exception($e->getMessage());
            }
            if ($res){
                $temp = base64_encode($tempencrypted);
                $encrypted = $encrypted.$temp;
            }else{
                return "Fail";
            }
        }
         return $encrypted;
    }

    public function decrypt($data) {
        $decrypted = "";
        //分段
        $len = 172;
        $m = strlen($data)/$len;

        if($m * $len !=strlen($data)){
            $m = $m+1;
        }

        for($i=0;$i<$m;$i=$i+1){
            $temp = "";
            if ($i < $m - 1)
            {
                $temp =  substr($data,$i*$len,$len);
            }
            else{
                $temp = substr($data,$i*$len);
            }
            if (openssl_private_decrypt(base64_decode($temp), $tempdecrypted, $this->privkey)){
                $decrypted = $decrypted.$tempdecrypted;
            }else{
                return "Fail";
            }
        }
        return base64_decode($decrypted);
    }
}
class FingerPrintResponse {
    public $FingerPrint;
    public $ServerPublicKey;
    public $VerifyString;
    public function __construct(){
        $this->ServerPublicKey = Config::find(1)->publickey;
        $this->FingerPrint = Config::find(1)->fingerprint;
    }
}
class ConfigResponse {
    public $Config;
    public $VerifyString;
    public $Provider;
}
