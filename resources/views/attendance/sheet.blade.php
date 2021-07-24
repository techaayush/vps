<!DOCTYPE HTML>
<html>
<head>
    <style type="text/css" >
        @page { 
            size: landscape;
            /*scale: 75;*/
        }
        .tg  {
            border-collapse:collapse;
            border-spacing:0;
        }
        .tg td, .tg th{
            border-style:solid;
            border-width:1px;
            font-family:Arial, sans-serif;
            font-size:14px;
            overflow:hidden;
            padding:10px 5px;
            word-break:normal;
        }
        
        .tg .tg-1wig{
            font-weight:bold;
            text-align:left;
            vertical-align:top
        }
        .tg .tg-4erg{
            border-color:inherit;
            font-style:italic;
            font-weight:bold;
            text-align:left;
            vertical-align:top
        }
        .tg .tg-fymr{
            border-color:inherit;
            font-weight:bold;
            text-align:left;
            vertical-align:top
        }
        .tg .tg-7btt{
            border-color:inherit;
            font-weight:bold;
            text-align:center;
            vertical-align:top
        }
        .tg .tg-0pky{
            border-color:inherit;
            text-align:left;
            vertical-align:top
        }
        .tg .tg-dvpl{
            border-color:inherit;
            text-align:right;
            vertical-align:top
        }
        .tg .tg-6ic8{
            border-color:inherit;
            font-weight:bold;
            text-align:right;
            vertical-align:top
        }
        .tg .tg-0lax{
            text-align:left;
            vertical-align:top
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body data-gr-c-s-loaded="true">
    <div style="text-align: center;">
        <h2>Vidhya Public School, Rau</h2>
    </div>
    <table class="tg" style="table-layout: fixed;width: 1902px;">
        <colgroup>
            <col style="width: 44px;">
            <col style="width: 68px;">
            <col style="width: 150px;">
            <col style="width: 150px;">
            <col style="width: 88px;">
            <col style="width: 88px;">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 28px">
            <col style="width: 30px">
            <col style="width: 29px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 30px">
            <col style="width: 31px">
            <col style="width: 31px">
            <col style="width: 32px">
            <col style="width: 32px">
            <col style="width: 31px">
            <col style="width: 31px">
            <col style="width: 33px">
            <col style="width: 32px">
            <col style="width: 34px;">
            <col style="width: 86px;">
            <col style="width: 86px;">
            <col style="width: 61px;">
            <col style="width: 35px;">
        </colgroup>
        <thead>
            <tr>
                <th class="tg-fymr" colspan="37">{{$session}}</th>
                <th class="tg-fymr" colspan="4">Last Month</th>
            </tr>
            <tr>
                <th class="tg-7btt" colspan="37">{{(!empty($studentsList) && count($studentsList))?$studentsList[0]->className:''}}</th>
                <th class="tg-fymr" colspan="4">Curr Month</th>
            </tr>
            <tr>
                <th class="tg-fymr" colspan="37">{{date('F')}}</th>
                <th class="tg-4erg" colspan="4">Total</th>
            </tr>
            <tr>
                <th class="tg-fymr">S No.</th>
                <th class="tg-fymr">Sch No.</th>
                <th class="tg-fymr">Student Name</th>
                <th class="tg-fymr">Father Name</th>
                <th class="tg-fymr">DOB</th>
                <th class="tg-fymr">Caste</th>
                <th class="tg-fymr">1</th>
                <th class="tg-fymr">2</th>
                <th class="tg-fymr">3</th>
                <th class="tg-fymr">4</th>
                <th class="tg-fymr">5</th>
                <th class="tg-fymr">6</th>
                <th class="tg-fymr">7</th>
                <th class="tg-fymr">8</th>
                <th class="tg-fymr">9</th>
                <th class="tg-fymr">10</th>
                <th class="tg-fymr">11</th>
                <th class="tg-fymr">12</th>
                <th class="tg-fymr">13</th>
                <th class="tg-fymr">14</th>
                <th class="tg-fymr">15</th>
                <th class="tg-fymr">16</th>
                <th class="tg-fymr">17</th>
                <th class="tg-fymr">18</th>
                <th class="tg-fymr">19</th>
                <th class="tg-fymr">20</th>
                <th class="tg-fymr">21</th>
                <th class="tg-fymr">22</th>
                <th class="tg-fymr">23</th>
                <th class="tg-fymr">24</th>
                <th class="tg-fymr">25</th>
                <th class="tg-fymr">26</th>
                <th class="tg-fymr">27</th>
                <th class="tg-fymr">28</th>
                <th class="tg-fymr">29</th>
                <th class="tg-fymr">30</th>
                <th class="tg-fymr">31</th>
                <th class="tg-fymr">Curr. Month</th>
                <th class="tg-fymr">Prev. Month</th>
                <th class="tg-fymr">Total</th>
                <th class="tg-fymr">%</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($studentsList) && count($studentsList))
                @foreach($studentsList as $sNo => $student)
                    <tr>
                        <td class="tg-0pky">{{$sNo+1}}</td>
                        <td class="tg-0pky">{{$student->scholar_number}}</td>
                        <td class="tg-0pky">{{$student->full_name}}</td>
                        <td class="tg-0pky">{{$student->father_name}}</td>
                        <td class="tg-0pky">{{date('d/m/Y',strtotime($student->dob))}}</td>
                        <td class="tg-0pky">{{$student->caste}}</td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                        <td class="tg-0pky"></td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td class="tg-0pky" colspan="41"></td>
            </tr>
            <tr>
                <td class="tg-dvpl" colspan="6"><span style="font-weight:bold">Day of Month</span>     <span style="font-weight:bold">................................</span></td>
                <td class="tg-fymr">1</td>
                <td class="tg-fymr">2</td>
                <td class="tg-fymr">3</td>
                <td class="tg-fymr">4</td>
                <td class="tg-fymr">5</td>
                <td class="tg-fymr">6</td>
                <td class="tg-fymr">7</td>
                <td class="tg-fymr">8</td>
                <td class="tg-fymr">9</td>
                <td class="tg-fymr">10</td>
                <td class="tg-fymr">11</td>
                <td class="tg-fymr">12</td>
                <td class="tg-fymr">13</td>
                <td class="tg-fymr">14</td>
                <td class="tg-fymr">15</td>
                <td class="tg-fymr">16</td>
                <td class="tg-fymr">17</td>
                <td class="tg-fymr">18</td>
                <td class="tg-fymr">19</td>
                <td class="tg-fymr">20</td>
                <td class="tg-fymr">21</td>
                <td class="tg-fymr">22</td>
                <td class="tg-fymr">23</td>
                <td class="tg-fymr">24</td>
                <td class="tg-fymr">25</td>
                <td class="tg-fymr">26</td>
                <td class="tg-fymr">27</td>
                <td class="tg-fymr">28</td>
                <td class="tg-fymr">29</td>
                <td class="tg-fymr">30</td>
                <td class="tg-fymr">31</td>
                <td class="tg-0pky" colspan="4"></td>
            </tr>
            <tr>
                <td class="tg-6ic8" colspan="6">Present</td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky" colspan="4"></td>
            </tr>
            <tr>
                <td class="tg-6ic8" colspan="6">Absent</td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky" colspan="4"></td>
            </tr>
            <tr>
                <td class="tg-6ic8" colspan="6">Total</td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-0pky" colspan="4"></td>
            </tr>
            <tr>
                <td class="tg-0pky" colspan="41"></td>
            </tr>
            <tr>
                <td class="tg-fymr" colspan="2">Class Teacher</td>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky" colspan="24"></td>
                <td class="tg-fymr" colspan="4">Head Master</td>
                <td class="tg-0pky" colspan="9"></td>
            </tr>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function(){
            // setTimeout(()=>{
            //     window.print();
            // },2000);
        });
    </script>
</body>
</html>






















<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<LINK REL="STYLESHEET" HREF="/mpt/stylesheet/stylecyber.css" MEDIA="SCREEN,PRINT">
<LINK REL="STYLESHEET" HREF="/mpt/stylesheet/sstyle.css" MEDIA="SCREEN,PRINT">
<LINK REL="STYLESHEET" HREF="/mpt/stylesheet/etreasuries-links.css" MEDIA="SCREEN,PRINT">
<TITLE>Cyber Treasury </TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<style type="text/css">
.bg1{color:#ff0000}
</style>
<STYLE TYPE="text/css">
  @font-face {
    font-family: HINBmith0;
    font-style:  normal;
    font-weight: 700;
    src: url(/mpt/eot/HINBMIT0.eot);
  }
</STYLE>
<style TYPE="text/css">
 .hindi {
   font-family: HINBmith0;
    font-style:  normal;
    src: url('http://www.mptreasury.org/mpt/eot/HINBMIT0.eot');
  }
</style>

<script language="JavaScript">

function selfClose()
{

/* this code for chrome browser*/
window.open('','_self');
window.setTimeout("window.close();",45000)
/* end code for chrome browser*/

/* this code for IE browser*/
this.focus();
self.opener=this;
window.setTimeout("self.close();",45000)
/* end code for IE browser*/
}

function windowClose(){
/* this code for chrome browser*/
window.open('','_self');
window.close();
/* end code for chrome browser*/

/* this code for IE browser*/
this.focus();
self.opener=this;
self.close();
/* end code for IE browser*/

}
</script>

<script language="JavaScript">
window.onload = function(){
  window.history.forward();
}


window.onbeforeunload = function () {
 // alert("This event not allowed!!!!.");
   //in this place you can divert user on index page directly.
}
</script>

<script language="JavaScript">


function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function isEmptyField(field,message)
    {   
        var re = /\s/g;
        var str = field.replace(re, "");
        RegExp.multiline = true;
        if (str.length == 0)
        {
            alert("Please Enter/Select "+message);
            return true;
        }
        else
        {
            return false;
        }
    }

function submitForm()
    {       
        
        if (isEmptyField(document.frmCyberBankTreasury.scroll_no.value,'Scroll No')==true)          
        {
            document.frmCyberBankTreasury.scroll_no.focus();
            return false;
        }
        
        
        else
        {
        document.frmCyberBankTreasury.action="frmCyberTreasuryChallanAck.jsp";
        document.frmCyberBankTreasury.submit(); 
        }
        }
    
</script>
<script language="javascript">
function whichButton(event)
{
if (event.button==2)//RIGHT CLICK
  {
  alert("Not Allow Right Click!");
  }

}
function noCTRL(e)
{
var code = (document.all) ? event.keyCode:e.which;

var msg = "Sorry, this functionality is disabled.";
if (parseInt(code)==17) //CTRL
{
alert(msg);
window.event.returnValue = false;
}
} 
</script>


</HEAD>
<BODY  border=0 topmargin=0 leftmargin=0 rightmargin=0 bgcolor=#ffffff marginwidth=0 marginheight=0 >
<form name="frmCyberBankTreasury" method="post" enctype="application/x-www-form-urlencoded"  onSubmit="return submitForm()"  autoComplete="off"  ><tr><td valign=top>
<Table width=100% border=0 cellspacing=0 cellpadding=0 rightmargin=0>
  <tr>
    <td> <Table border=0 width=100% cellspacing=0 cellpadding=0>
        <TR>
          <td width=100% bgcolor=#aad1fd> <script src=/mpt/scripts/top.txt></script></TD>
        </TR>
      </Table></td>
  </tr><tr><td valign=top>
  <Table width=100% border=0 cellspacing=0 cellpadding=0 rightmargin=0><tr>
    <td width=14% valign=top> <br>
      <br>
      <br> <script src="/mpt/scripts/leftlinks.js">
    </script> </td>
    <td width="2" bgcolor="#98928E"></td><td>
    <TABLE width=100% border=0 cellspacing=0 cellpadding=0><TR>
      <TD valign=top class=col1></TD><td valign=top width=100%>
      <table cellpadding=0 cellspacing=0 border=0 width=100% >
        <tr>
          <td><table border=0  cellspacing=0 cellpadding=2 width=100%>
              <tr>
                <td><table border=0 class=COL2 cellspacing=0 cellpadding=4  width=100%>
                    <tr>
                      <td><table cellpadding=0 cellspacing=0 border=0 width=100%>
                          <tr>
                            <td align=center width=60% ><table  border=0 cellpadding=1 cellspacing=0 class=col3>
                                <td align=center>&nbsp;<font size=4 ><b>CYBER
                                    TREASURY</b></font>&nbsp;</td>
                              </table></td>
                            <td align=right></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
            </table>
              </td>
          </tr>
        


<table border=0  cellspacing=0 cellpadding=0   rightmargin=0 width=100%   id="printableArea" >
                    <tr >
                      <td align="center" >
                      <table  width="75%" border=1 bordercolor="#666666"  align="center" cellpadding=0 cellspacing=0 style="border:solid ;border-color:#000000 ;border-width:thin ">
                      <tr>
                      <td align="center" colspan="2">
                      <table  align="center">
                      <tr>
                     <td align=center  width="5%">
                          <img src="/mpt/images/MP_logo.gif">
                          </td>
                          <td width="95%" align="center" >
                          <font size=3 ><b>Department of Finance, Government of Madhya Pradesh</b></font></td>
                                
                            </tr>
                            <tr>
                             <td  colspan="2" align=center >&nbsp;<font size=3 ><b>Acknowledgement Receipt for Online Tax Payment to M.P.State Government</b></font>&nbsp;</td>
                            </tr>
                            </table>
                     <tr height="30px" valign="top">
                <td width="50%"><font size="-1">&nbsp;TIN (Tax payment Identification Number) / Enrollment/Registration No.&nbsp;:</font>&nbsp; null &nbsp; &nbsp; &nbsp;<br>&nbsp;</td>
                 <td width="50%" ><font size="-1">&nbsp;Depositor/Dealer Name&nbsp;:</font>&nbsp;GOLDEN VIDHYA SHIKSHAN SAMITI<br><font size="-1">&nbsp;Address&nbsp;:</font>&nbsp;   RAU INDORE Madhya Pradesh</td>
                
                </tr >
              
               <tr height="30px" valign="top" >
                <td><font size="-1">&nbsp;Head of A/c details&nbsp;:</font> &nbsp;1475--00--200--0000 &nbsp; &nbsp; &nbsp;</td>
                <td   ><font size="-1">&nbsp;Concern Period&nbsp;: </font><br>&nbsp;From Date:&nbsp;null &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; To Date: &nbsp; null</td>
               
            <tr height="35px" valign="top" >
                 <td > <font size="-1">&nbsp;Name of Bank :</font>&nbsp;State Bank Of India&nbsp; &nbsp; &nbsp; </td>
                </td>
                 <td > <font size="-1">&nbsp;District Name :</font>&nbsp;INDORE&nbsp; &nbsp; &nbsp; </td>
                </td>
              </tr>
            

    
              </tr>
               <tr  height="30px" valign="top">
                <td  ><font size="-1">&nbsp;Bank Scroll No.&nbsp;:</font> &nbsp;49032&nbsp; &nbsp; &nbsp;</td>
                <td  ><font size="-1">&nbsp;Bank Scroll Date &nbsp;:</font>&nbsp;13062020 &nbsp; &nbsp; &nbsp; </td>
                
                 
              </tr>
              <tr  height="30px" valign="top" >
                <td colspan="2" ><font size="-1">&nbsp;Date and time of Transaction&nbsp;&nbsp;&nbsp;&nbsp;:</font>&nbsp;13&#47;06&#47;2020 11&#58;54&#58;17</td>
                
                
              </tr>
              
               <tr  height="30px" valign="top">
                <td  ><font size="-1">&nbsp;Amount&nbsp;:</font> &nbsp;2000&nbsp; &nbsp; &nbsp;</td>
                <td  ><font size="-1">&nbsp;Amount in words&nbsp;:</font>&nbsp;Two Thousand Only. &nbsp; &nbsp; &nbsp; </td>
                </tr>
                
               <tr  height="30px" valign="top" >
                <td colspan="2" ><font size="-1">&nbsp;Challan Identification No(CIN)&nbsp;&nbsp;&nbsp;:</font>&nbsp;SBIN000615914751306202049032</td>
                
                
              </tr>
             
                <tr height="30px" valign="top">
               
                <td colspan="2" ><font size="-1">&nbsp;Bank Reference No(BRN)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</font>&nbsp;CPAADTOGZ8
                </td>
              </tr>
              <tr  height="30px" valign="top">
                <td colspan="2" >&nbsp;<font size="-1">Cyber Receipt No. (CRN)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</font> MPT147513062020000025
                
              </tr>
             <tr height="30px" valign="top">
                
                 <td colspan="2"><font size="-1">&nbsp;Treasury Challan number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</font> 14752030 &nbsp; &nbsp; &nbsp;
                </td>
              </tr>
              <tr height="25px"  align="center">
                 <td colspan="2"  align="center" > <font size="-1" color="#FF0000">Note: Challan search facility is available at www. mptreasury.org</font></td>
                
                </td>
              </tr>
             
            
    </table>
    

            
               </table>
<table align="center">
                <tr>
                <TD align="center" >
                 <input  type="image" onClick="printDiv('printableArea')" src="/mpt/images/printsave.JPG"  value="Save" border="0" >
                <a href=http://www.mptreasury.org/index.html target=_parent> <img border="0" alt="Close" src="/mpt/images/close.JPG" ></a>
                </td>
                
                 </tr>
                
 </table>

</form>
    <tr>
    <td colspan=2 align=center><script  src=/mpt/scripts/bottom.txt>
    </script>
    </td >
  </tr>
</table >
</BODY>
</HTML>
 -->