.. include: : ../Includes.txt

.. users-manual:

=======================================
Users manual
=======================================
 
.. Documentation of how to use the extension, 
.. how it works, how to apply it, if it's a website plugin.
..    
.. Language should be non-technical, explaining, using small examples.
.. Don't use to many acronyms unless they have been explained.
..    
.. Provide screenshots of a neutral Backend.
.. Have in mind that the Users manual could possibly be re-used in a 
.. larger documentation compilation, for example when a company generates
.. a documentation for its client.
..   
.. Target group: **Users**
.. Possible subsection: FAQ


**On this page:**

.. contents::
   :local:
   :depth: 3


Send your first newsletter
==========================

#. In TYPO3 Backend, in list mode. Create a new RecipientList (eg:
   http://www.example.com/typo3/alt\_doc.php?edit[tx\_newsletter\_domain\_model\_recipientlist][1]=new)

   #. Pick a few BE-users
   #. Save

#. Select the module “Newsletter”
#. Select the page you want to send as newsletter
#. On the tab “Newsletter > Status”, check that there is no errors
#. On the tab “Newsletter > Settings”, enter the name and email of the sender
#. On the tab “Newsletter > Sending”

   #. Select a RecipientList
   #. Select the time when the Newsletter will start sending
   #. Click on the button “Add to Queue”

The newsletter will be sent via the Scheduler task at the time it was
planned, or, for testing purpose, you can manually trigger the task
within Scheduler. Statistics are available as soon as a newsletter is
queued. So it is possible to check what’s going on.

How to compose a newsletter
===========================

Make it self contained
----------------------
Newsletters should be "self-contained". This means that the don't refer
to external resources with the exception of images.
CSS should be included inline but will receive limited support.
See `email-standards.org <http://www.email-standards.org>`_ and
`campaignmonitor <http://www.campaignmonitor.com/css>`_.


Marker substitution
-------------------

Simple substitutions
~~~~~~~~~~~~~~~~~~~~
The extension ext:newsletter offers marker substitution in the 
newsletter content. Any field available via RecpientList will be 
substituted if found. You can choose one of two possible notations:

- :code:`###my_field###`

- :code:`http://my_field`

The second form is can conveniently be created as hyperlink from
within the RTE (TYPO3's rich text editor).

By using the SQL RecipientList we can select several other fields to
personalize the newsletter with the recipient's name, address, some
specially generated links or anything else needed.

In addition, the extension ext:newsletter provides two 
*built-in markers*:

-  :code:`###newsletter_view_url###`: This is the URL to view the 
   newsletter in a browser

-  :code:`###newsletter_unsubscribe_url###`: This is the URL to 
   unsubscribe from the newsletter. Going to that URL will register a
   bounce with type :code:`NEWSLETTER_UNSUBSCRIBE`.

Advanced substitutions
~~~~~~~~~~~~~~~~~~~~~~
You can also do boolean evaluation with the marker fields. 
Example: If you write a marker like this::

   ###:IF: my_field ###<p>Bla bla bla</p>###:ENDIF:###

the payload :code:`<p>Bla bla bla</p>` will only be shown if the 
code:`my_field` field evaluates to True in PHP. You can also add an 
else-branch::

   ###:IF: my_field ###<h1>Foo</h1>###:ELSE:###<h1>Bar</h1>###:ENDIF:###

This can be useful to present different content to different recipients.


How to configure a newsletter
=============================

Recipient lists
---------------

There are several ways to define a list of recipients. Those are:

-  **SQL:**
   Specify SQL queries to fetch data from any table that has at 
   least an 'email' field.

-  **BE-users:**
   Select existing backend users.

-  **FE-Groups with FE-Users:**
   Select frontend groups containing frontend users.

-  **Page with FE-Users:**
   Select pages where frontend users are stored.

-  **CSV file:**
   Upload a CSV file containing users.

-  **CSV list:**
   Specify CSV content directly. For example copy and paste
   the content of a file.

-  **CSV url:**
   Specify an URL to fetch a CSV file from.

-  **HTML:**
   Fetch an URL and parse its content to find emails.

SQL Recipient Lists are, by far, the most flexible and powerful way do
define a list of recipient. It allow dynamic composition of string that
can be used in newsletter content. And it also allows to take action
(SQL queries) upon specific event (bounced email, unsubscribe). Thus we
**strongly recommend the use of SQL Recipient List** and to read the
:ref:`sql-examples-for-recipient-lists`.

Bounce account
--------------
There is a new record type called "BounceAccount". You should select a
bounce account for newsletter. The BounceAccount record is used in 
two ways:

- to provide an email address for the mail to bounce to 
  ("Return-Path:" header)

- to provide login information to the email account for the 
  bounce-system to login to.

Once a newsletter has a BounceAccount and the bounce Scheduler task is
enabled, the extension ext:newsletter will automatically attach the 
address as return-path, read the rejected emails and disable or delete 
the failed email addresses. The bounced emails will also appear in the 
statistics.

Unsubscription notifications
----------------------------
Unsubscription should be automated, for example via proper configuration
of SQL for bounced email. However it is possible to receive an email
whenever a recipient requests for unsubscription. To allow for this the
"Notification email" field needs to be specified in the extension 
configuration in the extension manager.


**Next pages:**

.. toctree::
   :maxdepth: 5
   :titlesonly:

   Screenshots/Index
   SQLExamplesForRecipientLists/Index
