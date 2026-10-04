<?php
/*
 * صفحة عرض وطباعة عقد الإيجار (صفحة مستقلة بدون قوالب لوحة التحكم)
 * الاستخدام: contract_print.php?id=رقم_العقد        (عرض)
 *            contract_print.php?id=رقم_العقد&print=1 (عرض + فتح نافذة الطباعة تلقائياً)
 */
session_start();

if (!isset($_SESSION['username'])) {
  header('Location:../../index.php');
  exit;
}

$GLOBALS['main']   = $_SESSION['username'];
$GLOBALS['mainid'] = $_SESSION['id'];
$GLOBALS['level']  = $_SESSION['level'];
$GLOBALS['lang']   = $_SESSION['lang'];
$GLOBALS['b_id']   = $_SESSION['b_id'];

$pageTitle = 'Contracts';

// تحميل الاتصال بقاعدة البيانات من init1.php مع تجاهل قالب لوحة التحكم (الهيدر والقائمة)
ob_start();
include '../../init1.php';
ob_end_clean();

$id        = isset($_GET['id']) ? $_GET['id'] : 0;
$autoPrint = isset($_GET['print']) && $_GET['print'] == '1';

  $stmt = $con->prepare("SELECT * from contract where contract_no = ?  and b_id  = ? ");
  $stmt->execute(array($id,$b_id));
  $row = $stmt->fetch();

  if ($row) {

  // بيانات الفرع (الترويسة)
  $stmt = $con->prepare(" SELECT * FROM  branchen  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $infoEn = $stmt->fetch();

  // بيانات القاعة / الشعار
  $stmt = $con->prepare(" SELECT * FROM  branch  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $info = $stmt->fetch();

  // الشهر والسنة الهجرية
  $stvat = $con->prepare(" SELECT * FROM month   where  id = ? ");
  $stvat->execute(array($row['hm']));
  $hMonth = $stvat->fetch();
  $hMonth = $hMonth ? $hMonth['name'] : '';

  $stvat = $con->prepare(" SELECT * FROM year   where  id = ? ");
  $stvat->execute(array($row['hy']));
  $hYear = $stvat->fetch();
  $hYear = $hYear ? $hYear['name'] : '';

  }

  $e = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
 ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>عقد إيجار <?php echo $row ? $e($row['contract_no']) : ''; ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    @page {
      size: A4 portrait;
      margin: 8mm 10mm;
    }

    .contract-a4 {
      direction: rtl;
      font-family: 'Tajawal', 'Cairo', Tahoma, Arial, sans-serif;
      font-size: 9pt;
      line-height: 1.4;
      color: #222;
      background: #fff;
      width: 210mm;
      min-height: 297mm;
      margin: 20px auto;
      padding: 10mm 12mm;
      box-sizing: border-box;
      box-shadow: 0 0 12px rgba(0, 0, 0, .15);
    }
    .contract-a4 *, .contract-a4 *::before, .contract-a4 *::after { box-sizing: border-box; }

    /* الترويسة */
    .contract-a4 .c-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 6mm;
      padding-bottom: 2mm;
      border-bottom: 2px solid #1f4e8c;
    }
    .contract-a4 .c-header .side { flex: 1; font-size: 8.5pt; line-height: 1.5; color: #444; }
    .contract-a4 .c-header .side p { margin: 0; }
    .contract-a4 .c-header .side h2 {
      font-family: 'Cairo', sans-serif;
      font-size: 14pt;
      font-weight: 700;
      color: #1f4e8c;
      margin: 0 0 1mm;
    }
    .contract-a4 .c-header .side.en { direction: ltr; text-align: left; }
    .contract-a4 .c-header .side.ar { text-align: right; }
    .contract-a4 .c-header .logo { flex: 0 0 34mm; text-align: center; }
    .contract-a4 .c-header .logo img { max-height: 22mm; max-width: 34mm; object-fit: contain; }

    .contract-a4 .c-title {
      text-align: center;
      margin: 2.5mm 0 2mm;
    }
    .contract-a4 .c-title h1 {
      display: inline-block;
      font-family: 'Cairo', sans-serif;
      font-size: 14pt;
      font-weight: 700;
      margin: 0;
      padding: 0 8mm;
      border: 1.5px solid #1f4e8c;
      border-radius: 4px;
      color: #1f4e8c;
    }
    .contract-a4 .c-title .no { display: block; font-size: 10pt; margin-top: 1mm; color: #1f4e8c; font-weight: 700; }

    /* القيم المعبأة */
    .contract-a4 .v {
      font-weight: 700;
      color: #000;
      padding: 0 1.5mm;
      border-bottom: 1px dotted #777;
      white-space: nowrap;
    }

    .contract-a4 .intro p { margin: 0 0 0.8mm; text-align: justify; }
    .contract-a4 .intro .agree { font-weight: 700; margin-top: 1mm; }

    /* البنود */
    .contract-a4 ol.terms {
      margin: 1mm 0 0;
      padding-right: 6mm;
      padding-left: 0;
    }
    .contract-a4 ol.terms li {
      margin-bottom: 0.5mm;
      text-align: justify;
      padding-right: 1mm;
    }
    .contract-a4 ol.terms li::marker { font-weight: 700; color: #1f4e8c; }

    .contract-a4 table.money {
      width: 100%;
      border-collapse: collapse;
      margin: 1.5mm 0;
      font-size: 8.5pt;
      text-align: center;
    }
    .contract-a4 table.money th,
    .contract-a4 table.money td { border: 1px solid #bbb; padding: 0.4mm 2mm; }
    .contract-a4 table.money th { background: #e3ecf7; font-weight: 700; }
    .contract-a4 table.money td:first-child { text-align: right; font-weight: 600; }

    .contract-a4 .notes { margin: 2mm 0 0; }

    /* التواقيع */
    .contract-a4 .c-footer {
      display: flex;
      justify-content: space-between;
      gap: 8mm;
      margin-top: 4mm;
      page-break-inside: avoid;
      break-inside: avoid;
    }
    .contract-a4 .c-footer .party {
      flex: 1;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 2mm 4mm;
    }
    .contract-a4 .c-footer h5 {
      font-family: 'Cairo', sans-serif;
      font-size: 11pt;
      font-weight: 700;
      margin: 0 0 2mm;
      color: #1f4e8c;
    }
    .contract-a4 .c-footer p { margin: 0 0 2mm; }
    .contract-a4 .c-footer .stamp {
      flex: 0 0 30mm;
      border: 1px dashed #aaa;
      border-radius: 50%;
      height: 24mm;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #999;
      font-weight: 700;
    }

    html, body { margin: 0; padding: 0; background: #e9edf2; }

    /* شريط الأدوات */
    .toolbar {
      position: sticky;
      top: 0;
      z-index: 10;
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 10px;
      background: #1f4e8c;
      font-family: 'Cairo', Tahoma, sans-serif;
      direction: rtl;
    }
    .toolbar button,
    .toolbar a {
      font-family: inherit;
      font-size: 14px;
      font-weight: 600;
      padding: 6px 18px;
      border: 0;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      color: #1f4e8c;
      background: #fff;
    }
    .toolbar .muted { background: transparent; color: #fff; border: 1px solid rgba(255, 255, 255, .6); }

    .not-found {
      max-width: 480px;
      margin: 80px auto;
      padding: 30px;
      text-align: center;
      background: #fff;
      border-radius: 6px;
      font-family: 'Cairo', Tahoma, sans-serif;
      direction: rtl;
    }

    @media print {
      html, body { background: #fff !important; margin: 0 !important; padding: 0 !important; }
      .contract-a4 {
        width: auto;
        min-height: 0;
        margin: 0;
        padding: 0;
        box-shadow: none;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      .no-print, .no-print * { display: none !important; }
    }
  </style>
</head>
<body>

<div class="toolbar no-print">
  <?php if ($row) { ?>
  <button type="button" onclick="window.print()">طباعة</button>
  <?php } ?>
  <a href="contracts.php?do=Manage" class="muted">رجوع للعقود</a>
</div>

<?php if (!$row) { ?>

<div class="not-found">
  <h3>العقد غير موجود</h3>
  <p>لم يتم العثور على عقد بهذا الرقم.</p>
</div>

<?php } else { ?>

<div class="contract-a4">

  <!-- الترويسة -->
  <header class="c-header">
    <div class="side ar">
      <h2><?php echo $e($info['name']); ?></h2>
      <p>س.ت: <?php echo $e($info['Cphone']); ?></p>
      <p>هاتف: <?php echo $e($info['Phone']); ?> - فاكس: <?php echo $e($info['Fax']); ?></p>
      <p>جوال: <?php echo $e($info['Mobile']); ?> - <?php echo $e($info['Mobile1']); ?></p>
      <p><?php echo $e($info['Country']); ?></p>
      <p>الرقم الضريبي: <?php echo $e($info['Vat_Number']); ?></p>
    </div>

    <div class="logo">
      <img src="../../layout/dist/img/<?php echo $e($info['Avatar']); ?>" alt="logo">
    </div>

    <div class="side en">
      <h2><?php echo $e($infoEn['name']); ?></h2>
      <p>C.R: <?php echo $e($infoEn['Cphone']); ?></p>
      <p>Tel: <?php echo $e($infoEn['Phone']); ?> - Fax: <?php echo $e($infoEn['Fax']); ?></p>
      <p>Mobile: <?php echo $e($infoEn['Mobile']); ?> - <?php echo $e($infoEn['Mobile1']); ?></p>
      <p><?php echo $e($infoEn['Country']); ?></p>
      <p>VAT No: <?php echo $e($infoEn['Vat_Number']); ?></p>
    </div>
  </header>

  <div class="c-title">
    <h1>عقد إيجار</h1>
    <span class="no">رقم العقد: <?php echo $e($row['contract_no']); ?></span>
  </div>

  <!-- المقدمة -->
  <section class="intro">
    <p>
      إنه في يوم <span class="v"><?php echo $e($row['day']); ?></span>
      - <span class="v"><?php echo $e($row['bhd']); ?></span>
      الموافق <span class="v"><?php echo $e($row['date']); ?> م</span>
    </p>
    <p>تم بعون الله وتوفيقه الاتفاق بين كل من:</p>
    <p>
      <strong>أولاً:</strong> صاحب <span class="v"><?php echo $e($info['name']); ?></span> بالأحساء - <strong>طرف أول (مؤجر)</strong>.
    </p>
    <p>
      <strong>ثانياً:</strong> <span class="v"><?php echo $e($row['name']); ?></span>
      صاحب الهوية رقم <span class="v"><?php echo $e($row['hafiza_no']); ?></span>
      - جوال رقم <span class="v"><?php echo $e($row['phone']); ?><?php if (!empty($row['phone1'])) { echo ' / ' . $e($row['phone1']); } ?></span>
      - <strong>طرف ثانٍ (مستأجر)</strong>.
    </p>
    <p class="agree">وأقر الطرفان بكامل أهليتهما المعتبرة شرعاً واتفقا على ما يلي:</p>
  </section>

  <!-- البنود -->
  <ol class="terms">
    <li>بموجب هذا العقد أجّر الطرف الأول للطرف الثاني <span class="v"><?php echo $e($info['name']); ?></span> الكائنة بمحاسن، وما تضمنته من أثاث ومفروشات وأدوات، وهي على أحسن حال وصالحة للغرض المستأجرة لأجله.</li>

    <li>
      مدة العقد تبدأ من الساعة <span class="v"><?php echo $e($row['fclock']); ?></span>
      يوم <span class="v"><?php echo $e($row['s_name']); ?> <?php echo $e($row['hd']); ?>/<?php echo $e($hMonth); ?>/<?php echo $e($hYear); ?>هـ</span>
      الموافق <span class="v"><?php echo $e($row['start_date']); ?></span>،
      وتنتهي في تمام الساعة <span class="v"><?php echo $e($row['tclock']); ?></span>
      يوم <span class="v"><?php echo $e($row['e_name']); ?> <?php echo $e($row['hd'] + 1); ?>/<?php echo $e($hMonth); ?>/<?php echo $e($hYear); ?>هـ</span>
      الموافق <span class="v"><?php echo $e($row['end_date']); ?></span>.
    </li>

    <li>تعهد الطرف الثاني باستعمال الموقع للغرض الذي أُعد من أجله، والمحافظة على أثاثه ومفروشاته الموجودة به ومبانيه وديكوراته.</li>

    <li>
      اتفق الطرفان على قيمة الإيجار وتفاصيل السداد كالتالي:
      <table class="money">
        <thead>
          <tr>
            <th>البيان</th>
            <th>المبلغ</th>
            <th>ضريبة القيمة المضافة (15%)</th>
            <th>المجموع (ريال)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>قيمة الإيجار</td>
            <td><?php echo $e($row['m']); ?></td>
            <td><?php echo $e($row['youm']); ?></td>
            <td><strong><?php echo $e($row['rent_price']); ?></strong></td>
          </tr>
          <tr>
            <td>المدفوع (العربون)</td>
            <td><?php echo $e($row['cdp']); ?></td>
            <td><?php echo $e($row['dpv']); ?></td>
            <td><strong><?php echo $e($row['down_payment']); ?></strong></td>
          </tr>
          <tr>
            <td>المتبقي</td>
            <td><?php echo $e($row['crv']); ?></td>
            <td><?php echo $e($row['rv']); ?></td>
            <td><strong><?php echo $e($row['remaining']); ?></strong></td>
          </tr>
        </tbody>
      </table>
    </li>

    <li>عند إلغاء الحجز لا يُرد العربون المدفوع، ومدة استرجاع التأمين شهر من تاريخ الحفل، بعدها يعتبر التأمين من ضمن إيجار القاعة ولا يحق المطالبة به.</li>
    <li>يدفع المستأجر <span class="v"><?php echo $e($row['tameen']); ?></span> ريال تأميناً للقاعة قبل الزواج بـ (7) أيام، ويلتزم بالزيادة في حالة الأضرار البالغة.</li>
    <li>لا يُرجع العربون في حالة إلغاء عقد إيجار القاعة وقيمته <span class="v"><?php echo $e($row['down_payment']); ?></span> ريال، وإذا أوجد مستأجراً يحل مكانه يُخصم فقط <span class="v"><?php echo $e($row['subtraction']); ?></span> ريال.</li>
    <li><strong>لا يُستبدل الحجز حتى يتوفر مستأجر آخر يحل محله، وإلا يُخصم العربون.</strong></li>
    <li>لا يحق لمستأجر القاعة تأجيرها لطرف ثالث إطلاقاً (يُمنع أي حفل خارج القاعة المغلقة إلا بتصريح من الشرطة أو الإمارة).</li>
    <li>يُمنع منعاً باتاً النوم في القاعة من قبل أهل العروسين أو المدعوين.</li>
    <li>يجب تسليم مفاتيح القاعة فور الانتهاء من الزواج (منعاً لتحمل أي مسؤولية).</li>
    <li>عدم إدخال الأرز داخل قاعة الرجال أو النساء، ويقتصر على قاعة الطعام.</li>
    <li>عند طلب صاحب الحفل حضور أهله والعروس قبل الساعة الرابعة يدفع إيجاراً قدره 300 ريال.</li>
    <li>صاحب الفرح يتحمل مسؤولية التفحيط وإطلاق النار أو استخدام الألعاب النارية داخل وخارج القاعة، أو في حالة الشجار، أو إدخال جوال الكاميرا أو التصوير في قاعة النساء.</li>
    <li>عدم استخدام الفحم داخل القاعة نهائياً. <strong>(يلتزم المستأجر بدفع باقي قيمة الإيجار في حالة عدم إقامة الحفل)</strong></li>
    <li>الطاقة الاستيعابية لصالة الرجال <span class="v"><?php echo $e($info['mhc']); ?></span> فرد، والطاقة الاستيعابية لصالة النساء <span class="v"><?php echo $e($info['whc']); ?></span> فرد.</li>
    <li>عدد المتزوجين <span class="v"><?php echo $e($row['marrid_no']); ?></span> فقط.</li>
    <li>إذا حدث تخريب في محتويات القاعة تُحجز الكوشة إلى حين دفع قيمة التخريب.</li>
    <li>يُمنع الشكشكة والدبكات وجلسات العود داخل وخارج الصالة، ويُمنع منعاً باتاً إطلاق الأعيرة النارية وحمل السلاح والألعاب النارية.</li>
    <li><strong>في حال دفع المتبقي من إيجار القاعة قبل الزواج لا يُسترد مهما كانت الظروف.</strong></li>
    <li>عند عمل العقد الرجاء مراجعة قسم الشرطة (الضبط الإداري) من أجل إحضار تفويض لإقامة الحفل.</li>
    <li>يتعهد الطرف الثاني بعدم حمل السلاح أو وضع مواد ملتهبة أو ضارة داخل وخارج القاعة أو إطلاق النار أو استخدام الألعاب النارية من قبله أو أحد المدعوين، وفي حال خلاف ذلك يكون مسؤولاً أمام السلطات الحكومية ويتحمل كل ما يترتب على ذلك.</li>
    <li>العرضة والسامري تقام فقط داخل قاعة الرجال، والمستأجر يتحمل تكلفة التلفيات ولا يحق له الاعتراض.</li>
    <li>يتعهد الطرف الثاني بمسؤوليته عن كل حريق أو سرقة تحصل للموقع أو موجوداته مهما كانت الأسباب.</li>
  </ol>

  <?php if (trim((string) $row['note']) !== '') { ?>
  <p class="notes"><strong>ملاحظات:</strong> <?php echo nl2br($e($row['note'])); ?></p>
  <?php } ?>

  <!-- التواقيع -->
  <footer class="c-footer">
    <div class="party">
      <h5>الطرف الأول (المؤجر)</h5>
      <p>الاسم: <strong><?php echo $e($info['name']); ?></strong></p>
      <p>التوقيع: ..............................</p>
    </div>
    <div class="stamp">الختم</div>
    <div class="party">
      <h5>الطرف الثاني (المستأجر)</h5>
      <p>الاسم: <strong><?php echo $e($row['name']); ?></strong></p>
      <p>التوقيع: ..............................</p>
    </div>
  </footer>

</div>

<?php if ($autoPrint) { ?>
<script>
  window.addEventListener('load', function () {
    var printed = false;
    function doPrint() {
      if (printed) { return; }
      printed = true;
      setTimeout(function () { window.print(); }, 300);
    }
    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(doPrint);
      setTimeout(doPrint, 2500);
    } else {
      doPrint();
    }
  });
</script>
<?php } ?>

<?php } ?>

</body>
</html>
