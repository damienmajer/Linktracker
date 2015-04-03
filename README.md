#Linktracker

* Author: [Damien Majer](http://www.damienmajer.com/)

## Version 1.1

This is an EE2 port of Oliver Heine’s EE1 AJAX Linktracker.

## Description

This module allows you to track clicks on arbitrary links that have an ID attribute. You can use it to track file downloads, outgoing links or internal navigation links. 

## Installation

1. Include the linktracker.js file in your preferred directory
2. Copy the linktracker folder to ./system/expressionengine/third_party/
3. In EE, browse to Add-ons > Modules and click the 'Install' link for the Linktracker module

## Adding the tracking code to your templates

Include the following at the end of each of your templates on in your footer global if you have one:

	<script src="http://www.yourdomain.com/linktracker.js"></script>
	<script>
	{exp:linktracker:apiurl}
	</script>
	
Be sure to change the source parameter to the correct URL.

## Example Usage

Add a unique ID attribute to any link that you wish to track. This may be links to external links, internal links, links to files… it doesn’t matter as long as it has and id:

	<a id="holiday-photos" href="http://www.yourdomain.com/pictures.zip">My latest album</a> 

This link will show up under the Link ID holiday-photos in the click statistics in the module’s CP index page.

## Displaying the number of clicks for a link

The following tag outputs the number of clicks for a given Link ID. It’s a single tag that doesn’t have a closing tag.

	{exp:linktracker:clicks link_id="holiday-photos"} 

## Click Statistics

In EE, browse to Add-ons > Modules > Linktracker where you’ll find a list of all Link IDs and the number of times they have been clicked.

To the right there is a Reset link on every line that resets the counter for the respective Link ID.

If you click on a Link ID you get a detailed listing of every click for that ID.