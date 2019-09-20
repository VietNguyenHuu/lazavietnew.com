<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<h2><font size="4">Mì bay đang là món ăn được nhiều người quan tâm gần đây !!</font></h2><div><font size="4"><br></font></div><h3>Mì bay là gì ?</h3><div><br></div>Trước hết thì cần phải khẳng định rằng mì bay tất nhiên không phải là cách viết sai chính tả của mì cay. <b>Mì bay</b> là món ăn mới lạ và độc đáo có nguồn gốc từ&nbsp;Singapore. Và ngay sau đó, như đúng tên gọi, món mì này đã nhanh chóng lan rộng và '&nbsp;<i>BAY '&nbsp;</i>đến Việt Nam.<div><br></div><div><h3>Mì bay có gì đặc biệt ?</h3><div><br></div><div>Cái tên thôi thì mì bay cũng đã là đặc biệt rồi. Và thế thì 'mì bay' có thật sự bay được không ?&nbsp;</div><div>Mì bay thu hút sự chú ý của rất nhiều cư dân mạng gần đây là vì cách trinh bày món ăn độc đáo và mới lạ, với một chiếc que nhỏ ở giữa tô mì rồi sau đó vắt mì lên chiếc que này, thêm vào việc trang trí các phụ gia làm cho tô mì bay trông rất hấp dẫn.&nbsp;</div><div><br></div><div>Nếu chỉ nhìn qua thì ta sẽ có cảm giác như những sợi mì như đang có 'ma thuật' lơ lững trong không gian mà không cần phải dùng đũa gắp lên.</div><div><br></div><div>Thế thì cứ cho là nó có thể ' <i>bay</i> ' được đi !!</div><div><br></div><h3>Vậy địa điểm ăn mì bay ở đâu và giá ra sao ?</h3><div><br></div><div>Ngon, mới, lạ, đẹp mắt, và thêm một điều nữa là giá thành rất phải chăng. Chỉ với 50.000đ đến 120.000đ là bạn đã có thể tìm cho mình một combo mì bay 'ngon ngất ngây và đẹp mê say'.</div><div><br></div><div style="text-align: center;"><img src="http://muaban246.com/assets/img/nicedit/4527.gif"><br></div><div style="text-align: center;"><font color="#666666">(Ảnh minh họa: combo mì bay với xiên nướng)</font></div><div style="text-align: center;"><font color="#666666"><br></font></div><div style="text-align: left;"><br></div><div><font color="#000000">Và sau đây là các điểm ăn mì bay hot nhất tại sài gòn</font></div></div><blockquote style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><div><font color="#000000"><br></font></div><div><font color="#0000cc">Đường Đinh Tiên Hoàng, quận 1, TP.HCM.</font><br></div></div><div><font color="#000000"><br></font></div><div><font color="#000000"><br></font></div></blockquote><div><div><br><div><br></div><div><br><div><br></div><div><br></div></div></div></div>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
