<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <style>
        <!--
        /* Font Definitions */
        @font-face
        {font-family:"Cambria Math";
            panose-1:2 4 5 3 5 4 6 3 2 4;}
        @font-face
        {font-family:"Yu Mincho";
            panose-1:2 2 4 0 0 0 0 0 0 0;}
        @font-face
        {font-family:Calibri;
            panose-1:2 15 5 2 2 2 4 3 2 4;}
        @font-face
        {font-family:"\@Yu Mincho";}
        /* Style Definitions */
        p.MsoNormal, li.MsoNormal, div.MsoNormal
        {margin:0mm;
            margin-bottom:.0001pt;
            font-size:12.0pt;
            font-family:"Calibri",sans-serif;}
        a:link, span.MsoHyperlink
        {color:#0563C1;
            text-decoration:underline;}
        a:visited, span.MsoHyperlinkFollowed
        {color:#954F72;
            text-decoration:underline;}
        .MsoChpDefault
        {font-size:12.0pt;
            font-family:"Calibri",sans-serif;}
        /* Page Definitions */
        @page WordSection1
        {size:612.0pt 792.0pt;
            margin:72.0pt 72.0pt 72.0pt 72.0pt;}
        div.WordSection1
        {page:WordSection1;}
        -->
    </style>

</head>

<body lang=JA link="#0563C1" vlink="#954F72">

<div class=WordSection1>


    <p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

    <p class=MsoNormal><span lang=EN-US>Dear {{ $user->email }},<br>
                    <br>
                </span></p>

    <p class=MsoNormal><span lang=EN-US>Thanks for signing up for a Brain Salvation account. To verify your account, please return to the app and use the identification code below:</span></p>

    <p class=MsoNormal><span lang=EN-US>&nbsp;</span><br></p>
    <p class=MsoNormal><span lang=EN-US>{{ $user->verification_id }}</span><br></p>
    <p class=MsoNormal><span lang=EN-US>&nbsp;</span><br></p>

    <p class=MsoNormal><span lang=EN-US>If you have trouble using the app, you can also verify your account on the web by clicking on this link</span></p>

    <p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

    <p class=MsoNormal><a href="{{ url('/verify/'.$user->id) }}"> {{ url('/verify/'.$user->id) }}</a></p>

    <p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

    <p class=MsoNormal><span lang=EN-US>If you did not use the brainsalvation
                    service, please ignore this message.<br>
                    <br>
                </span></p>

    <p class=MsoNormal><span lang=EN-US>Thank you.</span></p>

    <p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

    <p class=MsoNormal><span lang=EN-US>Yours sincerely,<br>
                    The brainsalvation Team</span></p>

    <p class=MsoNormal><span lang=EN-US><a href="https://www.brainsalvation.com">https://www.brainsalvation.com</a></span></p>

    <p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

    <p class=MsoNormal><span lang=EN-US>Have any questions? Contact us at info@brainsalvation.com</span></p>

    <p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

    <p class=MsoNormal><span lang=EN-US>Copyright Pegara, Inc.  All rights
                    reserved.</span></p>

    <p class=MsoNormal><span lang=EN-US>4000 Barranca Parkway, Suite 250, Irvine,CA
                    92604</span></p>

</div>

</body>

</html>
