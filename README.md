# ghoma-google-home
Low tech way to connect G-Homa wifi plugs to your Google Home.

The quick explanation is that we going to find out which message the ghoma is app is sending to the G-Homa-Server to turn the plug on and off. This message we are going to immitate with a script. In this case PHP, because i use that on daily basis, but when you see the structure it is easy to set it up in different languages. Then we use the IFTTT app to connect a voice-command to a webhook (php script) to control the plug.

When you want to make your own server, look at this github repo: https://github.com/rodney42/node-ghoma

## Needed:
1. G-homa wallplug
2. The ghoma app on your phone
3. Proxy tool installed on your mac / pc.
4. Google Home
5. IFTTT app on your phone

## Setup G-Homa wall plug and install the app
Make sure everything is installed (plug and app) and that you can control the wall plug with the app on your phone. 

## Install and setup a proxy
In order to see what message G-Homa is sending to the server we need to intercept the message. Herefore we use a proxytool. 
Install proxy software on your Mac or PC. I used https://www.charlesproxy.com/download/ 

Charles allows you to sniff the packets sent through HTTP from your actual device, the way you use it is simple:

* Download and install Charles, run the program and specify the proxy port
* Connect the Android Device to the very same network of the computer running Charles
* Go to Wifi-Settings in Android Device and long tap on the network connected, then go to Modify Network-> Show advanced Options
* Set Proxy as Manual and in Proxy Host name set your computer IP "192.xxx.x.x" and in the Proxy port add the same port specified in Charles Proxy Settings.

Now you will see all the requests from your phone in Charles. We are only interested in the communication with the G-Homa server. So open the app on your phone and turn the G-Homa plug on and off. The look in Charles and look for http://m.g-homa.com:
wsi > action > ActionWebService.asmx?wsdl  (http://m.g-homa.com/wsi/action/ActionWebService.asmx?wsdl)
Click on this, and on the right side on "contents" and on the lower bar on "Text". Here you see the exact SOAP message G-Homa sends:

`<?xml version="1.0" encoding="UTF-8"?><v:Envelope xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns:d="http://www.w3.org/2001/XMLSchema" xmlns:c="http://schemas.xmlsoap.org/soap/encoding/" xmlns:v="http://schemas.xmlsoap.org/soap/envelope/"><v:Header /><v:Body><service xmlns="http://www.thinkhome.com.cn/" id="o0" c:root="1"><json i:type="d:string">{"head":{"code":"120"},"body":{"authentication":{"FUserAccount":"xxxxxx@xxxxxxxx.com","FPassword":"xxxxxxxxxxxxxxxxxxxxxx"},"action":{"FActionType":"5","FActionNo":"xxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxx","FKeyNum":"0","FAction":"1","FValue":""}}}</json></service></v:Body></v:Envelope>`

Copy and Paste the message to the clipboard.

!!! Here you see that your username and encrypted password are send over http:// which is easily to intercepted. Best would be that G-Homa should send the request over https://. 

## PHP Script Example
You can use the sample PHP file. Keep in mind it is a sample and it is not secure! 
Get your FUserAccount, FPassword and FActionNo from the message and use it in the PHP Script. 
Save the script on a location which can be reached over the internet. Usage:
ON = http://www.somewhere-online-you-put-the-file.com/plugController.php?plug=on
OFF = http://www.somewhere-online-you-put-the-file.com/plugController.php?plug=off

Call it via your browser and you should be able to control the plug.

!!! Keep in mind this is not a very secure method. Everybody who knows the urls can make the call over the internet and control the plugs. You probably can figure out some ways to make it more secure. 

## Install and setup the IFTTT app
Make sure the app is installed working correctly. 
* Add a "New Applet". 
* For the THIS part Select the Google Assistent. 
* Select "simple phrase". By "what do you want to say?" you can fill in "lights on".
* For the THAT part select Maker Webhooks. Select make a webrequest.
* For the URL you can write the whole url ending on "plugController.php?plug=on".

Make another one for "Lights off".

## Shout it out
When everything is setup and in place. You can shout "LIGHTS ON" and "LIGHTS OFF" all night long.. all night.




