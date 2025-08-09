<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertNewTemplateForNewCommentAndAssignCase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('email_templates')->insert([

            [
                'name' => 'Case Assign',
                'type' => 'case_assign',
                'subject' => 'Case Assign',
                'is_default' => 1,
                'value' => <<<'EOD'
                <table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container" style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;" width="100%">
    <tbody>
    <tr style="vertical-align:top;" valign="top">
        <td style="vertical-align:top;" valign="top">

            <div style="background-color:#415094;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <div align="center" class="img-container center fixedwidth" style="padding-right:30px;padding-left:30px;">


                                    <a href="#">
                                        <img border="0" class="center fixedwidth" src="http://infixlive.com/advtestnew/public/uploads/settings/logo.png" style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;" width="150" alt="logo.png">
                                    </a>


                                </div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#415094;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <div align="center" class="img-container center autowidth" style="padding-right:20px;padding-left:20px;">

                                    <img border="0" class="center autowidth" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU" style="text-decoration:none;height:auto;border:0;max-width:541px;" width="541" alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">


                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#7c32ff;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                    <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <table cellpadding="0" cellspacing="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;" width="100%">
                                    <tbody>
                                    <tr style="vertical-align:top;" valign="top">
                                        <td align="center" style="vertical-align:top;padding-bottom:5px;padding-left:0px;padding-right:0px;padding-top:25px;text-align:center;width:100%;" valign="top" width="100%">
                                            <h1 style="line-height:120%;text-align:center;margin-top:0px;margin-bottom:0px;"><font color="#555555" face="Arial, Helvetica Neue, Helvetica, sans-serif"><span style="font-size:36px;">{ASSIGNED_FROM} Assigned A Case To You</span></font><br></h1>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div style="line-height:1.8;padding:20px 15px;">
                                    <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                        <p style="text-align:left;margin:0px;line-height:1.8;"><span style="color:rgb(115,116,135);font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:18px;">A Case </span><a href="%7BCASE_URL%7D" target="_blank" style="color:rgb(115,116,135);font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:16px;background-color:rgb(255,255,255);text-align:left;" rel="noreferrer noopener">{CASE_TITLE}</a><span style="color:rgb(115,116,135);font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:16px;"> is assigned to you.</a></p><p style="text-align:left;margin:0px;line-height:1.8;"><br></p></div></div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#7c32ff;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">


                                <div style="color:#262b30;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                    <div class="txtTinyMce-wrapper" style="line-height:1.2;font-size:12px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#262b30;">
                                        <p style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;"><span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">© 2021 Infix Advocate | </span><span style="background-color:transparent;text-align:left;"><font color="#ffffff">89/2 Panthapath, Dhaka 1215, Bangladesh</font></span><br></p></div></div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#7c32ff;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <table cellpadding="0" cellspacing="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;" width="100%">
                                    <tbody>
                                    <tr style="vertical-align:top;" valign="top">
                                        <td align="center" style="vertical-align:top;padding-top:5px;padding-right:0px;padding-bottom:5px;padding-left:0px;text-align:center;" valign="top">


                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody>
                                    <tr style="vertical-align:top;height:40px;" valign="top">
                                        <td align="center" style="vertical-align:top;text-align:center;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:6px;" valign="top"></td>
                                        <td style="font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:15px;color:#9d9d9d;vertical-align:middle;" valign="middle"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
EOD
                ,
                'available_variable' => '{ASSIGNED_FROM},{CASE_TITLE},{ASSIGNED_TO},{CASE_URL},{EMAIL_SIGNATURE}',
                'status' => true
            ],

            [
                'name' => 'New Comment',
                'type' => 'new_case_comment',
                'subject' => 'New Comment on Case',
                'is_default' => 1,
                'value' => <<<'EOD'
               <table class="nl-container" style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <tbody>
    <tr style="vertical-align:top;" valign="top">
        <td style="vertical-align:top;" valign="top">

            <div style="background-color:#415094;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <div class="img-container center fixedwidth" style="padding-right:30px;padding-left:30px;" align="center">


                                    <a href="#">
                                        <img class="center fixedwidth" src="http://infixlive.com/advtestnew/public/uploads/settings/logo.png" style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;" alt="logo.png" width="150" border="0">
                                    </a>


                                </div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#415094;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <div class="img-container center autowidth" style="padding-right:20px;padding-left:20px;" align="center">

                                    <img class="center autowidth" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU" style="text-decoration:none;height:auto;border:0;max-width:541px;" alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU" width="541" border="0">


                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#7c32ff;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                    <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <table style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="vertical-align:top;" valign="top">
                                        <td style="vertical-align:top;padding-bottom:5px;padding-left:0px;padding-right:0px;padding-top:25px;text-align:center;width:100%;" width="100%" valign="top" align="center">
                                            <h1 style="line-height:120%;text-align:center;margin-top:0px;margin-bottom:0px;"><font face="Arial, Helvetica Neue, Helvetica, sans-serif" color="#555555"><span style="font-size:36px;">{COMMENTED_BY} comment in {CASE_TITLE}</span></font><br></h1>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div style="line-height:1.8;padding:20px 15px;">
                                    <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                        <p style="text-align:left;margin:0px;line-height:1.8;"><span style="color:rgb(115,116,135);font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:18px;">{COMMENTED_BY} is comment on a case {CASE_TITLE} </span></p><p style="text-align:left;margin:0px;line-height:1.8;"><span style="color:rgb(115,116,135);font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:18px;">{COMMENT}<br></span></p><p style="text-align:left;margin:0px;line-height:1.8;"><br></p></div></div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#7c32ff;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">


                                <div style="color:#262b30;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                    <div class="txtTinyMce-wrapper" style="line-height:1.2;font-size:12px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#262b30;">
                                        <p style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;"><span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">© 2021 Infix Advocate |&nbsp;</span><span style="background-color:transparent;text-align:left;"><font color="#ffffff">89/2 Panthapath, Dhaka 1215, Bangladesh</font></span><br></p></div></div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div style="background-color:#7c32ff;">
                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">


                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                            <div class="col_cont" style="width:100%;">

                                <table style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="vertical-align:top;" valign="top">
                                        <td style="vertical-align:top;padding-top:5px;padding-right:0px;padding-bottom:5px;padding-left:0px;text-align:center;" valign="top" align="center">


                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody>
                                    <tr style="vertical-align:top;height:40px;" valign="top">
                                        <td style="vertical-align:top;text-align:center;padding-top:5px;padding-bottom:5px;padding-left:5px;padding-right:6px;" valign="top" align="center"></td>
                                        <td style="font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:15px;color:#9d9d9d;vertical-align:middle;" valign="middle"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
EOD
                ,
                'available_variable' => '{COMMENTED_BY}, {CASE_TITLE}, {COMMENT}, {EMAIL_SIGNATURE}, {CASE_URL}',
                'status' => true
            ],


        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
