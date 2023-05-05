<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->
<?php $complain_info = complain::getComplainInfo($com_cid);
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
$fname = $_SESSION['EWT_NAME'];
$lname = $_SESSION['EWT_SURNAME'];
$sql_profile = "SELECT * FROM M_PER_PROFILE
                                LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
                                WHERE
                                    M_PER_PROFILE.PER_NAME_TH LIKE '%" . $fname . "%'
                                AND M_PER_PROFILE.PER_LASTNAME_TH LIKE '%" . $lname . "%'
                                ";
$result = dbdpis::getFetch($sql_profile);


?>

<link rel="stylesheet" href="assets/css/poll.css">

<style>
    /*----------------------*/
    select option {
        background-color: #fff;
        color: #55595c;
    }

    .form-control {
        border: 1px solid #981c9d;
    }

    select option[value="0"] {
        background-color: #82288c;
        color: #fff;
    }

    ::placeholder {
        font-weight: bold;
    }


    .StepBox-882-sm {
        background-color: #82288c;
    }

    .StepBox-BE4-sm {
        background-color: #be4ec3;
    }

    .StepBox-882-sm {
        background-color: #82288c;
    }

    .block {
        position: absolute;
        left: 0;
        top: 0;
    }

    .slidercaptcha {
        margin: 0 auto;
        width: 100%;
        height: 300px;
        border-radius: 4px;
        margin-top: 0;
    }

    .slidercaptcha canvas:first-child {
        border-radius: 5px;
        border: 1px solid #e6e8eb;
    }

    .sliderContainer {
        position: relative;
        text-align: center;
        line-height: 40px;
        background: #f7f9fa;
        color: #45494c;
        border-radius: 2px;
    }

    .sliderbg {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        background-color: #f7f9fa;
        height: 40px;
        border-radius: 2px;
        border: 1px solid #e6e8eb;
    }

    .sliderContainer_active .slider {
        top: -1px;
        border: 1px solid #1991FA;
    }

    .sliderContainer_active .sliderMask {
        border-width: 1px 0 1px 1px;
    }

    .sliderContainer_success .slider {
        top: -1px;
        border: 1px solid #02c076;
        background-color: #02c076 !important;
        color: #fff;
    }

    .sliderContainer_success .sliderMask {
        border: 1px solid #52CCBA;
        border-width: 1px 0 1px 1px;
        background-color: #D2F4EF;
    }

    .sliderContainer_success .sliderIcon:before {
        content: "\f00c";
    }

    .sliderContainer_fail .slider {
        top: -1px;
        border: 1px solid #f35c59;
        background-color: #f35c59;
        color: #fff;
    }

    .sliderContainer_fail .sliderMask {
        border: 1px solid #f35c59;
        background-color: #f7dcdd;
        border-width: 1px 0 1px 1px;
    }

    .sliderContainer_fail .sliderIcon:before {
        content: "\f00d";
    }

    .sliderContainer_active .sliderText,
    .sliderContainer_success .sliderText,
    .sliderContainer_fail .sliderText {
        display: none;
    }

    .sliderMask {
        position: absolute;
        left: 0;
        top: 0;
        height: 40px;
        border: 0 solid #d1e9fe;
        background: #d1e9fe;
        border-radius: 2px;
    }

    .slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        background: #fff;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        transition: background .2s linear;
        border-radius: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider:hover {
        background: #009efb;
        color: #fff;
        border-color: #009efb;
    }

    .slider:hover .sliderIcon {
        background-position: 0 -13px;
    }

    .sliderText {
        position: relative;
    }

    .sliderIcon {}

    .refreshIcon {
        position: absolute;
        right: 5px;
        top: 5px;
        cursor: pointer;
        padding: 6px;
        color: #fff;
        background-color: #ff4c4c;
        font-size: 14px;
        border-radius: 50px;
    }

    .refreshIcon:hover {
        color: #fff;
    }



    @media (min-width: 1px) and (max-width: 767px) {
        .dis-mobile {
            display: block;
        }

        .dis-pc {
            display: none;
        }

        .fa-envelope {
            color: #fff;
            font-size: 65px;
        }

        .fa-file-lines {
            color: #fff;
            font-size: 65px;
        }

        .fa-paper-plane {
            color: #fff;
            font-size: 65px;
        }

        .StepBox-882-sm {
            text-align: center;
        }

        .StepBox-BE4-sm {
            text-align: center;
        }

        .StepBox-882-sm {
            text-align: center;
        }
    }

    @media (min-width: 768px) and (max-width: 9999px) {
        .dis-mobile {
            display: none;
        }

        .dis-pc {
            display: block;
        }
    }

    .arrow-right-BE4-sm {
        width: 0;
        height: 0;
        border-right: 30px solid transparent;
        border-top: 30px solid #BE4EC3;
        border-left: 30px solid transparent;

        position: absolute;
        left: 42%;

    }

    .arrow-right-822-sm {
        width: 0;
        height: 0;
        border-right: 30px solid transparent;
        border-top: 30px solid #82288c;
        border-left: 30px solid transparent;

        position: absolute;
        left: 42%;

    }



    .article_nvt {
        color: #fff;
    }
</style>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<div class="dis-pc">
    <div class="container-fluid mar-t-90px bg--purple text-center">
        <div class="container py-5">
            <div class="article--topic"> แบบฟอร์มติดต่อสอบถาม </div>
            <small style="color: #fff;">
                <a href="index.php" title="หน้าหลัก" class="article_nvt">หน้าหลัก </a>
                <?php // echo article::article_group_parent($news_group['c_id']); 
                ?>
            </small>
        </div>
    </div>
</div>
<!-- แถบสีน้ำเงินหัวข้อข่าวสาร -->
<!--<div class="dis-pc">
    <div class="d-flex mb-3">
        <div class="p-2 StepBox-882 p-3">
            <h3 class="mt-2 mb-0"><i class="fa-solid fa-envelope"></i></h3>
            <p class="white-text">
                ตรวจสอบ และระบุ e-mail <br>
                ในข้อมูลผู้ใช้งานของท่าน ให้ครบถ้วนสมบูรณ์ <br>
                เพื่อใช้เป็นช่องในการติดต่อประสานงาน ในการให้ข้อมูล  <br>
                หรือ sแก้ไขปัญหาต่าง ๆ ตามที่ได้รับแจ้ง
            </p>
            <div class="arrow-right-822"></div>
        </div>
        <div class="p-2 StepBox-BE4  p-3">
            <h3 class="mt-2 mb-0"><i class="fa-regular fa-file-lines"></i></h3>
            <p class="white-text">เลือกหมวดหมู่ของเรื่อง  <br>
                ที่ต้องการติดต่อสอบถาม พร้อมทั้งระบุชื่อเรื่อง <br>
                และรายละเอียดให้ครบถ้วน
            </p>
                <div class="arrow-right-BE4"></div>
        </div>
        <div class="p-2 StepBox-882  p-3">
            <h3 class="mt-2 mb-0"><i class="fa-solid fa-paper-plane"></i></h3>
            <p class="white-text">เมื่อคลิกส่งข้อมูล  <br>
                เรื่องที่ต้องการสอบถามจะถูกส่งไปยังเจ้าหน้าที่ <br>
                ที่เกี่ยวข้อง ขอบคุณที่ใช้บริการ
            </p>
        </div>
    </div>
</div>-->

<!-- Open head page -->
<div class="container-fluid">
    <div class="container">
        <div class="text-center mt-3 mb-3">
            <h3 class="suppage"> แบบฟอร์มติดต่อสอบถาม </h3>
        </div>
    </div>
</div>
<!-- Open head page -->

<!-- Open News -->
<form name="contact_form" id="contact_form" enctype="multipart/form-data">
    <div class="contaier-fluid">
        <div class="container">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <label class="h2-color" for="name">ผู้ติดต่อ : </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ชื่อ-นามสกุล" value="<?php echo $full_name; ?>" disabled>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="h2-color" id="c_Complain_lead_ID" for="Complain_lead_ID">เลือกหมวดหมู่การติดต่อ : </label>
                    <select class="form-control" name="Complain_lead_ID" id="Complain_lead_ID">
                        <?php foreach ($complain_info["data"] as $value) { ?>
                            <option value="<?php echo $value["Complain_lead_ID"]; ?>" <?php echo ($com_cid == $value["Complain_lead_ID"] ? "selected" : ""); ?>><?php echo $value["Complain_lead_name"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12 col-sm-12">
                    <label class="h2-color" id="c_topic" for="topic">เรื่องที่ต้องการสอบถาม : </label>
                    <input type="text" class="form-control" name="topic" id="topic" placeholder="กรุณากรอกเรื่องที่ต้องการสอบถาม">
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-12">
                    <label class="h2-color" for="">รายละเอียด : </label>
                    <textarea class="form-control" name="detail" id="detail" placeholder="กรุณากรอกรายละเอียด" id="exampleFormControlTextarea1" rows="5"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label class="h2-color" for="">เอกสารแนบ (ถ้ามี) : </label>
                    <input type="file" class="form-control-file " name="attach_img" id="attach_img" onchange="checkFile(this)">
                    <smail class="text-danger">* ไฟล์ที่อนุญาตให้แนบได้ pdf,png,jpg ขนาดไฟล์ไม่เกิน 10 MB.</smail>
                </div>
            </div>


        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 mb-5">
                    <div class="card-body">
                        <div id="captcha"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 text-center">
                    <label class="h2-color" for="">กรุณาเลื่อนเพื่อปลดล็อด </label>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 text-center mb-3">
                    <span id="chk_captcha"></span>
                </div>
            </div>

            <style>
                button:disabled {
                    background-color: gray !important;
                    border-color: #727272 !important;
                }
            </style>

            <div class="row">
                <div class="col-xl-12 text-center mb-3">
                    <input type="hidden" name="Flag" id="Flag" value="AddComplain">
                    <input type="hidden" name="email" id="email" value="<?php echo $result["USR_EMAIL"]; ?>">
                    <input type="hidden" name="tel" id="tel" value="<?php echo $result["USR_TEL_PHONE"]; ?>">
                    <button type="button" name="btn_cancel" id="btn_cancel" class="btn btn-danger w-40">ยกเลิก</button>
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-success text-white w-40">ส่งข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Close News -->
<!-- <script>
    $(document).ready(function() {
        $('#btn_submit').prop('disabled', true);

        $("#contact_form").on("submit", function(event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);
            formData.append('name', $('#name').val());
            const nameArray = ['topic', 'Complain_lead_ID', 'name'];
            
            $.ajax({
                url: "ajax/contact_form.ajax.php",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data.status === 'success') {
                        alert(data.message);
                        $('#contact_form')[0].reset();
                        grecaptcha.reset();
                        $('#btn_submit').prop('disabled', true);
                    } else {
                        alert(data.message);
                        grecaptcha.reset();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });
</script> -->

<script>
    $(document).ready(function() {
        $('#btn_submit').prop('disabled', true);

        $("#contact_form").on("submit", function(event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);
            formData.append('name', $('#name').val());
            const nameArray = ['topic', 'Complain_lead_ID', 'name'];
            submitForm("ajax/contact_form.ajax.php", formData, nameArray);
        });
    });
</script>
<script>
function checkFile(input) {
  if (input.files && input.files[0]) {
    var fileSize = input.files[0].size / 1024 / 1024; // คำนวณขนาดไฟล์แปลงเป็น MB
    var fileType = input.files[0].type; // ดึงประเภทไฟล์
    if (fileSize > 10) { // ตรวจสอบขนาดไฟล์
      alert("ขนาดไฟล์เกิน 10 MB กรุณาเลือกไฟล์ใหม่");
      input.value = '';
    } else if (!fileType.includes('pdf') && !fileType.includes('png') && !fileType.includes('jpg')) { // ตรวจสอบนามสกุลไฟล์
      alert("รองรับไฟล์เฉพาะ PDF, PNG, และ JPG เท่านั้น");
      input.value = '';
    }
  }
}
</script>
<script>
    //---slider-captcha-js--
    (function() {
        "use strict";

        function u(n) {
            var i = document.getElementById(n.id),
                r = typeof n == "object" && n;
            return new t(i, r)
        }
        var r = function() {
                var u = arguments.length,
                    n = arguments[0] || {},
                    t, i, r;
                for (typeof n != "object" && typeof n != "function" && (n = {}), u == 1 && (n = this, t--), t = 1; t < u; t++) {
                    i = arguments[t];
                    for (r in i) Object.prototype.hasOwnProperty.call(i, r) && (n[r] = i[r])
                }
                return n
            },
            i = function(n) {
                return typeof n == "function" && typeof n.nodeType != "number"
            },
            t = function(n, i) {
                this.$element = n;
                this.options = r({}, t.DEFAULTS, i);
                this.$element.style.position = "relative";
                this.$element.style.width = this.options.width + "px";
                this.$element.style.margin = "0 auto";
                this.init()
            },
            n;
        t.VERSION = "1.0";
        t.Author = "argo@163.com";
        t.DEFAULTS = {
            width: 280,
            height: 155,
            PI: Math.PI,
            sliderL: 42,
            sliderR: 9,
            offset: 5,
            loadingText: "æ­£åœ¨åŠ è½½ä¸­...",
            failedText: "å†è¯•ä¸€æ¬¡",
            barText: "å‘å³æ»‘åŠ¨å¡«å……æ‹¼å›¾",
            repeatIcon: "fa fa-repeat",
            maxLoadCount: 3,
            localImages: function() {
                return "images/Pic" + Math.round(Math.random() * 4) + ".jpg"
            },
            verify: function(n, t) {
                var i = !1;
                return $.ajax({
                    url: t,
                    data: {
                        datas: JSON.stringify(n)
                    },
                    dataType: "json",
                    type: "post",
                    async: !1,
                    success: function(n) {
                        i = JSON.stringify(n);
                        console.log("è¿”å›žç»“æžœï¼š" + i)
                    }
                }), i
            },
            remoteUrl: null
        };
        window.sliderCaptcha = u;
        window.sliderCaptcha.Constructor = t;
        n = t.prototype;
        n.init = function() {
            this.initDOM();
            this.initImg();
            this.bindEvents()
        };
        n.initDOM = function() {
            var n = function(n, t) {
                    var i = document.createElement(n);
                    return i.className = t, i
                },
                v = function(n, t) {
                    var i = document.createElement("canvas");
                    return i.width = n, i.height = t, i
                },
                f = v(this.options.width - 2, this.options.height),
                e = f.cloneNode(!0),
                t = n("div", "sliderContainer"),
                l = n("i", "refreshIcon " + this.options.repeatIcon),
                o = n("div", "sliderMask"),
                y = n("div", "sliderbg"),
                s = n("div", "slider"),
                a = n("i", "fa fa-arrow-right sliderIcon"),
                h = n("span", "sliderText"),
                u, c;
            e.className = "block";
            h.innerHTML = this.options.barText;
            u = this.$element;
            u.appendChild(f);
            u.appendChild(l);
            u.appendChild(e);
            s.appendChild(a);
            o.appendChild(s);
            t.appendChild(y);
            t.appendChild(o);
            t.appendChild(h);
            u.appendChild(t);
            c = {
                canvas: f,
                block: e,
                sliderContainer: t,
                refreshIcon: l,
                slider: s,
                sliderMask: o,
                sliderIcon: a,
                text: h,
                canvasCtx: f.getContext("2d"),
                blockCtx: e.getContext("2d")
            };
            i(Object.assign) ? Object.assign(this, c) : r(this, c)
        };
        n.initImg = function() {
            var n = this,
                f = window.navigator.userAgent.indexOf("Trident") > -1,
                r = this.options.sliderL + this.options.sliderR * 2 + 3,
                e = function(t, i) {
                    var r = n.options.sliderL,
                        o = n.options.sliderR,
                        s = n.options.PI,
                        u = n.x,
                        e = n.y;
                    t.beginPath();
                    t.moveTo(u, e);
                    t.arc(u + r / 2, e - o + 2, o, .72 * s, 2.26 * s);
                    t.lineTo(u + r, e);
                    t.arc(u + r + o - 2, e + r / 2, o, 1.21 * s, 2.78 * s);
                    t.lineTo(u + r, e + r);
                    t.lineTo(u, e + r);
                    t.arc(u + o - 2, e + r / 2, o + .4, 2.76 * s, 1.24 * s, !0);
                    t.lineTo(u, e);
                    t.lineWidth = 2;
                    t.fillStyle = "rgba(255, 255, 255, 0.7)";
                    t.strokeStyle = "rgba(255, 255, 255, 0.7)";
                    t.stroke();
                    t[i]();
                    t.globalCompositeOperation = f ? "xor" : "destination-over"
                },
                o = function(n, t) {
                    return Math.round(Math.random() * (t - n) + n)
                },
                t = new Image,
                u;
            t.crossOrigin = "Anonymous";
            u = 0;
            t.onload = function() {
                n.x = o(r + 10, n.options.width - (r + 10));
                n.y = o(10 + n.options.sliderR * 2, n.options.height - (r + 10));
                e(n.canvasCtx, "fill");
                e(n.blockCtx, "clip");
                n.canvasCtx.drawImage(t, 0, 0, n.options.width - 2, n.options.height);
                n.blockCtx.drawImage(t, 0, 0, n.options.width - 2, n.options.height);
                var i = n.y - n.options.sliderR * 2 - 1,
                    u = n.blockCtx.getImageData(n.x - 3, i, r, r);
                n.block.width = r;
                n.blockCtx.putImageData(u, 0, i + 1);
                n.text.textContent = n.text.getAttribute("data-text")
            };
            t.onerror = function() {
                if (u++, window.location.protocol === "file:" && (u = n.options.maxLoadCount, console.error("can't load pic resource file from File protocal. Please try http or https")), u >= n.options.maxLoadCount) {
                    n.text.textContent = "åŠ è½½å¤±è´¥";
                    n.classList.add("text-danger");
                    return
                }
                t.src = n.options.localImages()
            };
            t.setSrc = function() {
                var r = "",
                    e;
                u = 0;
                n.text.classList.remove("text-danger");
                i(n.options.setSrc) && (r = n.options.setSrc());
                r && r !== "" || (r = "https://picsum.photos/" + n.options.width + "/" + n.options.height + "/?image=" + Math.round(Math.random() * 20));
                f ? (e = new XMLHttpRequest, e.onloadend = function(n) {
                    var i = new FileReader;
                    i.readAsDataURL(n.target.response);
                    i.onloadend = function(n) {
                        t.src = n.target.result
                    }
                }, e.open("GET", r), e.responseType = "blob", e.send()) : t.src = r
            };
            t.setSrc();
            this.text.setAttribute("data-text", this.options.barText);
            this.text.textContent = this.options.loadingText;
            this.img = t
        };
        n.clean = function() {
            this.canvasCtx.clearRect(0, 0, this.options.width, this.options.height);
            this.blockCtx.clearRect(0, 0, this.options.width, this.options.height);
            this.block.width = this.options.width
        };
        n.bindEvents = function() {
            var n = this;
            this.$element.addEventListener("selectstart", function() {
                return !1
            });
            this.refreshIcon.addEventListener("click", function() {
                n.text.textContent = n.options.barText;
                n.reset();
                i(n.options.onRefresh) && n.options.onRefresh.call(n.$element)
            });
            var r, u, f = [],
                t = !1,
                e = function(i) {
                    n.text.classList.contains("text-danger") || (r = i.clientX || i.touches[0].clientX, u = i.clientY || i.touches[0].clientY, t = !0)
                },
                o = function(i) {
                    var o;
                    if (!t) return !1;
                    var s = i.clientX || i.touches[0].clientX,
                        h = i.clientY || i.touches[0].clientY,
                        e = s - r,
                        c = h - u;
                    if (e < 0 || e + 40 > n.options.width) return !1;
                    n.slider.style.left = e - 1 + "px";
                    o = (n.options.width - 60) / (n.options.width - 40) * e;
                    n.block.style.left = o + "px";
                    n.sliderContainer.classList.add("sliderContainer_active");
                    n.sliderMask.style.width = e + 4 + "px";
                    f.push(Math.round(c))
                },
                s = function(u) {
                    var o, e;
                    if (!t || (t = !1, o = u.clientX || u.changedTouches[0].clientX, o === r)) return !1;
                    n.sliderContainer.classList.remove("sliderContainer_active");
                    n.trail = f;
                    e = n.verify();
                    e.spliced && e.verified ? (n.sliderContainer.classList.add("sliderContainer_success"), i(n.options.onSuccess) && n.options.onSuccess.call(n.$element)) : (n.sliderContainer.classList.add("sliderContainer_fail"), i(n.options.onFail) && n.options.onFail.call(n.$element), setTimeout(function() {
                        n.text.innerHTML = n.options.failedText;
                        n.reset();
                        $('#chk_captcha').text('Captcha ไม่ถูกต้องกรุณาลองใหม่อีกครั้ง!');
                        $('#btn_submit').prop('disabled', true);
                    }, 1e3))
                };
            this.slider.addEventListener("mousedown", e);
            this.slider.addEventListener("touchstart", e);
            document.addEventListener("mousemove", o);
            document.addEventListener("touchmove", o);
            document.addEventListener("mouseup", s);
            document.addEventListener("touchend", s);
            document.addEventListener("mousedown", function() {
                return !1
            });
            document.addEventListener("touchstart", function() {
                return !1
            });
            document.addEventListener("swipe", function() {
                return !1
            })
        };
        n.verify = function() {
            var n = this.trail,
                r = parseInt(this.block.style.left),
                t = !1;
            if (this.options.remoteUrl !== null) t = this.options.verify(n, this.options.remoteUrl);
            else {
                var i = function(n, t) {
                        return n + t
                    },
                    u = function(n) {
                        return n * n
                    },
                    f = n.reduce(i) / n.length,
                    e = n.map(function(n) {
                        return n - f
                    }),
                    o = Math.sqrt(e.map(u).reduce(i) / n.length);
                t = o !== 0
            }
            return {
                spliced: Math.abs(r - this.x) < this.options.offset,
                verified: t
            }
        };
        n.reset = function() {
            this.sliderContainer.classList.remove("sliderContainer_fail");
            this.sliderContainer.classList.remove("sliderContainer_success");
            this.slider.style.left = 0;
            this.block.style.left = 0;
            this.sliderMask.style.width = 0;
            this.clean();
            this.text.setAttribute("data-text", this.text.textContent);
            this.text.textContent = this.options.loadingText;
            this.img.setSrc()
        }
    })();

    // ----set-captcha with script
    var captcha = sliderCaptcha({
        id: 'captcha',
        loadingText: 'Loading...',
        failedText: 'Try again',
        barText: 'Slide right to fill',
        repeatIcon: 'fa fa-redo',
        onSuccess: function() {
            // var handler = setTimeout(function () {
            //     window.clearTimeout(handler);
            //     captcha.reset();
            // }, 500);
            setTimeout(function() {
                $('#chk_captcha').text('');
                $('#btn_submit').prop('disabled', false);
                //alert('Your captcha is successfully verified.');
                captcha.reset();
            }, 1000);
        },
        setSrc: function() {
            //return 'https://picsum.photos/' + Math.round(Math.random() * 136) + '.jpg';
        },
    });
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->