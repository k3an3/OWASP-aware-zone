OWASP-aware-zone
================
Live at <a href="demos.keaneokelley.com">demos.keaneokelley.com</a>

It's been done many times before, but I just had to do it myself. The goal of this project is to provide a variety of simple webapps that demonstrate classic webapp vulnerabilities in order to increase knowledge and awareness. Many, if not all of the vulnerabilities are listed on the OWASP Top 10. While most of these pitfalls can be avoided simply by making use of modern web frameworks and their built-in protections, it is still important to understand how these vulnerabilities work and how their exploitation can be prevented.

The basic requirements for this webapp are nginx/Apache, PHP, and MySQL. MySQL will need a database called 'sqldemo' which is controlled by a user with login details as username:password @ localhost. The SQL Injection demo will automatically create the required tables once you press its 'reset' button. Many of the demos use .txt files to store things. Permissions will need to be set such that the webserver can read and write to these files.

Most demos can be recovered simply by pressing the 'reset' button or by passing "?reset=true" into the URL bar.

Disclaimer:
These demos are provided for learning purposes only. None of the pages or code may be used to carry out actual attacks against real websites or people. I am not responsible
for anything you decide to do with the provided knowledge. Also, do not use any of this code in production.

Demos:
=====
<li><a href="burpsuite/index.php" style="color:white">Client-Side Validation Demo</a>
	<p>Demonstrates the importance of server-side input validation. The demo uses JavaScript to verify user input 
	(to make sure the text contains the string "awesome"), but this can be easily beaten by disabling JavaScript or using a 
	browser proxy tool such as <a href="http://portswigger.net/burp/Burpsuite." style="color:white">Burp Suite</a> to edit the 
	request post-JavaScript-validation. See <a href="https://blog.keaneokelley.com/client-vs-server-side-input-validation-demo/">this write-up</a> for more information.</p></li>
	<li><a href="xss/index.php" style="color:white">XSS Demo</a>
	<p><a href="https://www.owasp.org/index.php/Top_10_2013-A3-Cross-Site_Scripting_%28XSS%29">XSS (Cross-site-scripting)</a> is a 
	well-known and dangerous vulnerability. XSS is possible when a site allows arbitrary HTML to be injected into the page, usually a result of a poorly-sanitized input form.
	Since the injected HTML is rendered exactly like the rest of the page, there are no limits on what can be done. For example, script tags can be injected, redirecting users
	to malicious phishing pages or stealing their non-http-only session cookies.</p></li>
	<li><a href="sql/index.php" style="color:white">SQL Injection Demo</a>
	<p><a href="https://www.owasp.org/index.php/SQL_Injection">SQL injection</a> occurs when a website uses an SQL database but fails to sanitize the inputs, meaning a malicious user would be able to execute arbitrary SQL commands.
	SQL injection allows an attacker to fully manipulate the contents of the database, and sometimes even use it to attack other parts of the server.</p></li>
	<li>Coming soon: CSRF and more!</li>
</ul>
