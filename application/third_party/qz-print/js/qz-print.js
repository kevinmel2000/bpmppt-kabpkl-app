(function( $ ) {

	var $window = $(window),

		// Our main applet
		Qz = function ( element, options ) {
			var that = this;

			this.printer	= null;
			this.applet_id	= element;
			this.dimX		= '8.5in';
			this.dimY		= '11.0in';
			this.isAutoSize	= true;
			this.hostIp		= '192.168.1.254';
			this.hostPort	= 9100;
			this.isReady	= false;
		};

	Qz.prototype = {
		constructor: Qz,
		types: ['html', 'pdf', 'image', 'hex', 'xml' ,'pages', '64', 'zplimage', 'escimage', 'eplimage', 'file'],
		doPrint: function ( type, option ) {

			// chack are printing method supported
			if ( $.inArray( this.types, tipe) != -1 ) {

				// is printer seted up
				if ( this.printer != null ) {	
					this.printer.findPrinter("\\{dummy printer name for listing\\}");
					
					while (!printer.isDoneFinding()) {
						// Note, enless while loops are bad practice.
						// Create a JavaScript function called "jzebraDoneFinding()"
						// instead and handle your next steps there.
					}

					// Sample only: If a PDF printer isn't installed, try the Microsoft XPS Document
					// Writer. Replace this with your printer name.
					var printers = printer.getPrinters().split(",");

					for (i in printers) {
						if (printers[i].indexOf("Microsoft XPS") != -1 || printers[i].indexOf("PDF") != -1) {
							printer.setPrinter(i); 
						}	 
					}

					// No suitable printer found, exit
					if (printer.getPrinter() == null) {
						alert("Could not find a suitable printer");
						return;
					}

					switch(type){
						case 'html':
							var htmlOut	  = '<html><table face="monospace" border="1px"><tr height="6cm"><td valign="top">'+
											'<h2>* QZ Print Plugin HTML Printing *</h2>'+
											'<color=red>Version:</color> '+printer.getVersion()+'<br />'+
											'<color=red>Visit:</color> http://code.google.com/p/jzebra'+
											'</td><td valign="top"><img src="'+getPath()+'img/image_sample.png">'+
											'</td></tr></table></html>'

							// Append our image (only one image can be appended per print)
							printer.appendHTML( this._htmlFix( htmlOut ) );
							break;

						case 'pdf':
							// Append our pdf (only one pdf can be appended per print)
							printer.appendPDF(getPath() + "misc/pdf_sample.pdf");
							break;

						case 'image':
							// Using qz-print's "appendImage()" function, a png, jpeg file
							// can be sent directly to the printer supressing the print dialog
							// Example:
							// printer.appendImage("http://yoursite/logo1.png"); // ...etc

							// Optional, set up custom page size. These only work for PostScript printing.
							// setPaperSize() must be called before setAutoSize(), setOrientation(), etc.
							if (scaleImage) {
								printer.setPaperSize("8.5in", "11.0in"); // US Letter
								//printer.setPaperSize("210mm", "297mm"); // A4
								printer.setAutoSize(true);
								//printer.setOrientation("landscape");
								//printer.setOrientation("reverse-landscape");
								//printer.setCopies(3); //Does not seem to do anything
							}

							// Append our image (only one image can be appended per print)
							printer.appendImage(getPath() + "img/image_sample.png");
							break;

						case 'hex':
							// *NOTE* New syntax with version 1.5.4, no backslashes needed, which should fix \x00 JavaScript bug.
							// Can be in format "1B00" or "x1Bx00"
							printer.appendHex("4e0d0a713630390d0a513230332c32360d0a42352c32362c302c31412c332c372c3135322c422c2231323334220d0a413331302c32362c302c332c312c312c4e2c22534b55203030303030204d46472030303030220d0a413331302c35362c302c332c312c312c4e2c224a5a45425241205052494e54204150504c4554220d0a413331302c38362c302c332c312c312c4e2c2254455354205052494e54205355434345535346554c220d0a413331302c3131362c302c332c312c312c4e2c2246524f4d2053414d504c452e48544d4c220d0a413331302c3134362c302c332c312c312c4e2c225052494e5448455828292046554e43220d0a50312c310d0a");
							break;

						case 'xml':
							// Appends the contents of an XML file from a SOAP response, etc.
							// a valid relative URL or a valid complete URL is required for the XML
							// file. The second parameter must be a valid XML tag/node containing
							// base64 encoded data, i.e. <node_1>aGVsbG8gd29ybGQ=</node_1>
							// Example:
							// printer.appendXML("http://yoursite.com/zpl.xml", "node_1");
							// printer.appendXML("http://justtesting.biz/jZebra/dist/epl.xml", "v7:Image");
							printer.appendXML(getPath() + "misc/zpl_sample.xml", "v7:Image");
							
							// Send characters/raw commands to printer
							//printer.print(); // Can't do this yet because of timing issues with XML
							break;

						case 'pages':
							// something;
							// Mark the end of a label, in this case P1 plus a newline character
							// qz-print knows to look for this and treat this as the end of a "page"
							// for better control of larger spooled jobs (i.e. 50+ labels)
							printer.setEndOfDocument("P1,1\r\n");
							
							// The amount of labels to spool to the printer at a time. When
							// qz-print counts this many `EndOfDocument`'s, a new print job will 
							// automatically be spooled to the printer and counting will start
							// over.
							printer.setDocumentsPerSpool("2");
							
							printer.appendFile(getPath() + "misc/epl_multiples.txt");
							break;

						case '64':
							// something;
							printer.append64("QTU5MCwxNjAwLDIsMywxLDEsTiwialplYnJhIHNhbXBsZS5odG1sIgpBNTkwLDE1NzAsMiwzLDEsMSxOLCJUZXN0aW5nIHRoZSBwcmludDY0KCkgZnVuY3Rpb24iClAxCg==");
							break;

						case 'zplimage':
							// something;
							printer.append("^XA\n");
							printer.append("^FO50,50^ADN,36,20^FDPRINTED USING QZ PRINT PLUGIN " + printer.getVersion() + "\n"); 
						
							// A second (and sometimes third an fourth) parameter MUST be 
							// specified to "appendImage()", for qz-print to use raw image 
							// printing. If this is not supplied, qz-print will send PostScript
							// data to your raw printer! This is bad!
							printer.appendImage(getPath() + "img/image_sample_bw.png", "ZPLII");

							// Finish printing
							printer.append("^FS\n"); 
							printer.append("^XZ\n"); 
							break;

						case 'escimage':
							// something;
							printer.appendImage( getPath() + "img/image_sample_bw.png", "ESCP", "single");
							
							// Cut the receipt
							printer.appendHex("x1Dx56x41");
							break;

						case 'eplimage':
							// Send characters/raw commands to qz using "append"
							// This example is for EPL. Please adapt to your printer language
							// Hint: Carriage Return = \r, New Line = \n, Escape Double Quotes= \"
							printer.append("\nN\n"); 
							printer.append("q609\n");
							printer.append("Q203,26\n");
							printer.append("B5,26,0,1A,3,7,152,B,\"1234\"\n");
							printer.append("A310,26,0,3,1,1,N,\"SKU 00000 MFG 0000\"\n");
							printer.append("A310,56,0,3,1,1,N,\"QZ PRINT APPLET\"\n");
							printer.append("A310,86,0,3,1,1,N,\"TEST PRINT SUCCESSFUL\"\n");
							printer.append("A310,116,0,3,1,1,N,\"FROM SAMPLE.HTML\"\n");
							printer.append("A310,146,0,3,1,1,N,\"EDIT EPL_SAMPLE.TXT\"\n");
							
							printer.appendImage(getPath() + "img/image_sample_bw.png", "EPL", 150, 300);

							printer.append("\nP1,1\n");
							break;

						case 'file':
							// Using qz-print's "appendFile()" function, a file containg your raw EPL/ZPL
							// can be sent directly to the printer
							// Example: 
							// printer.appendFile("http://yoursite/zpllabel.txt"); // ...etc
							printer.appendFile(getPath() + "misc/" + file);
							break;

					}

					while (!printer.isDoneAppending()) {} //wait for image to download to java

					printer.print(); // send commands to printer
				}
				
				monitorPrinting();
			} else {
				alert('printing method is not supported currently.');
			}
		},
		findPrinter: function ( name ) {
			if (printer != null)
				printer.findPrinter("Zebra");

			this._findPrinter();
		},
		findPrinters: function () {
			if (printer != null)
				printer.findPrinter("\\{dummy printer name for listing\\}");

			this._findPrinters();
		},
		_doPrinting: function () {
			if (printer != null) {
				if (!printer.isDonePrinting()) {
						window.setTimeout(this._doPrinting(), 100);
				} else {
					var e = printer.getException();
					alert(e == null ? "Printed Successfully" : "Exception occured: " + e.getLocalizedMessage());
					printer.clearException();
				}
			} else {
				this._error();
			}
		},
		_findPrinter: function () {
			if (printer != null) {
				if (!printer.isDoneFinding()) {
					window.setTimeout(this._findPrinter(), 100);
				} else {
					var printer = printer.getPrinter();
					alert(printer == null ? "Printer not found" : "Printer \"" + printer + "\" found");
				}
			} else {
				this._error();
			}
		},
		_findPrinters: function () {
			if (printer != null) {
				if (!printer.isDoneFinding()) {
					window.setTimeout(this._findPrinters(), 100);
				} else {
					var printers = printer.getPrinters().split(",");
					for (p in printers) {
						alert(printers[p]);
					}	
				}
			} else {
				this._error();
			}
		},
		// Fixes some html formatting for printing. Only use on text, not on tags! Very important!
		// 1. HTML ignores white spaces, this fixes that
		// 2. The right quotation mark breaks PostScript print formatting
		// 3. The hyphen/dash autoflows and breaks formatting 
		_htmlFix: function ( html ) {
			return html.replace(/ /g, "&nbsp;").replace(/’/g, "'").replace(/-/g,"&#8209;");
		},
		_error: function ( message ) {
			if (message === undefined)
				alert("Applet not loaded!");

			alert(message);
		},
		_load: function () {
			this.printer.findPrinter("\\{dummy printer name for listing\\}");
			while (!this.printer.isDoneFinding()) {
				// Wait
			}
		},
		// Automatically gets called when the applet is finished loading
		_printReady: function () {
			this.printer = document.getElementById[this.applet_id];

			if ( this.printer != null ) {
				this.isReady = true;
				this.printer.findPrinter('zebra');

				console.log( this.printer.getVersion() );
			}
		}
	};

	var old = $.fn.jzebra

	$.fn.jzebra = function ( option ) {}

	$.fn.jzebra.Constructor = Qz

	$.fn.jzebra.noConflict = function () {
		$.fn.jzebra = old
		return this
	}

	$(window).bind("unload", function() {
		$("*:not('applet, object')").add(document).unbind();
	});

	$(function(){
		$('jZebra').Qz();
	});

})( jQuery );

