<!--#include file="Config.asp"--><%
userEmail=Request("userEmail")
userFriendEmail=Request("userFriendEmail")
userMessage=Request("userMessage")
If userMessage="" Then userMessage="..."

mBody="<font style='color:#000000;font-family:tahoma;font-size:11px'>"
mBody=mBody + "<b>Your Friend :</b> <a href='mailto:" & userEmail & "'>" & userEmail & "</a><br><br>"
mBody=mBody + "<b>thought you might be interested in :</b> <a href='" & c_StfLink & "'>" & c_StfLink & "</a><br><br>"
mBody=mBody + "<b>Your Friend's Message :</b> " & userMessage & " <br><br>"
mBody=mBody + "</font>"

'On Error Resume Next

Set mail=Server.CreateObject("JMail.Message")
mail.charset=c_Charset
mail.From=c_senderEmail
mail.FromName=c_fromName
mail.Addrecipient userFriendEmail
mail.Subject=c_StfSubject
mail.HTMLBody=mBody
mail.Body=mBody
mail.MailServerUserName=c_senderUsername
mail.MailServerPassword=c_senderPassword
mail.Send(c_senderMailServer)
Set mail=Nothing

Response.Write "sending=1"
%>
