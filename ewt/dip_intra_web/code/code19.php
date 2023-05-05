<script language="javascript">
function getMSXMLVersion() {
	var xml = "<?phpxml version='1.0' encoding='UTF-16'?><cjb></cjb>";

	var x = null;
var versions = new Array("Msxml2.DOMDocument.4.0", "Msxml2.DOMDocument.3.0", 
"Msxml2.DOMDocument", "Msxml.DOMDocument");
    for (i = 0; i < versions.length; i++) {
	    try {
		    objectName = versions[i];
	        x = new ActiveXObject(objectName);
	        x.loadXML(xml);
	        return objectName;
	    } catch(e) {

	    }
    };

    return "Not supported";
}

var MSXMLVersion = getMSXMLVersion();

function checkValidVersion() {
	switch(MSXMLVersion) {
		case "Not supported":
		return false;
		case "Msxml.DOMDocument":
		return false;
	    default:
	    return true;
    }
}

function showNews(newsLocation, xslLocation) 
{
	if (checkValidVersion()) 
	{
		var xmlNews = new ActiveXObject(MSXMLVersion);
		var xslNews = new ActiveXObject(MSXMLVersion);

		// Load news
        xmlNews.async = false;
        xmlNews.load(newsLocation);

        // Load the XSL
        xslNews.async = false;
        xslNews.load(xslLocation);

        // Transform
        return xmlNews.transformNode(xslNews);
    } 
	else 
	{
	    if (MSXMLVersion != "Not supported") 
		{
		    return "This browser does not support .";
	    } 
		else 
		{
	        return "This browser only support older version .";
        }
    }
}
</script>
<script language = "javascript">
document.write(showNews("http://thaisarn.com/services/distributor/xml_distributor.php?category=รัฐบาล& nlatest=7","http://www.thaisarn.com/xsl/news.xsl"));
</script>
