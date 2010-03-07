# A Guide To RoloPress

RoloPress is an application, built on the WordPress platform. It uses standard WordPress features like Posts, Custom Fields and Custom Taxonomies to transform WordPress into a contact Manager. RoloPress is infinitely expandable via Themes and Plugins, so you can make RoloPress your own.

## Installing RoloPress

RoloPress is as simple to install as any other WordPress theme. However, since it's a theme framework (more on that later), you need to install the **RoloPress Core** theme, and any RoloPress child theme. If you're reading this than you already have RoloPress Core. [You can download our standard RoloPress child theme here.][1] Both themes should be placed in your wp-content/themes directory. Just activate the child theme and you're ready to go

## RoloPress Auto Setup

Once you activate your RoloPress child theme, a few things automatically happen:

1.  Four Pages get automatically created: "Add Company", "Add Contact", "Edit Company" and "Edit Contact". The proper theme template is also applied to them. We don't recommend deleting these pages.

2.  Six Custom Taxonomies are created as well: "RoloPress Type", "Company", "City, "State", "Zip" and Country". You really don't need to know what they do, because RoloPress fills them in automatically for you.

3.  A whole bunch of Custom Fields are assigned to Contacts and Companies. Again, unless you're a developer, don't worry about it... RoloPress will take care of you.

## What's a Theme Framework? RoloPress is a

*Theme Framework*. Which means it's quite easy for you to modify the look and feel and still keep RoloPress future-proof so you can take advantage of cool new features we implement. RoloPress uses the Parent/Child relationship to make this easy for you. The RoloPress Core theme, the Parent, does all the heavy lifting and is the brains behind RoloPress. All your cool styling changes and modifications should be made in a RoloPress Child Theme. This way, when we introduce new RoloPress features you just overwrite your existing RoloPress Core with the new one, all your changes are safe, and you upgrade your RoloPress. To learn more about Parent-Child Themes you may want to [read this article.][2]
## Widget Areas

RoloPress has 6 widget-ready areas, that can be used creatively to customize your RoloPress.

1.  ### Menu

    RoloPress comes with a default Menu. If you don't like it, it's easy to modify by dragging widgets to this area.

2.  ### Primary

    Usually used as a Sidebar. If you're using a 3-column layout then it will appear on the left. If you choose 2-columns than it occupies the top of the sidebar.

3.  ### Secondary

    Located immediately after Primary in the markup. Typically used as a sidebar. If you're using a 3-column layout then it will appear on the right. If you choose 2-columns than it will appear directly under Primary.

4.  ### Widget Page

    RoloPress actually includes two theme templates that can be built entirely with widgets. One template is a full widget page with no sidebars, the other uses your standard sidebar layout. A real cool way of using this might be to create a "Dashboard" of many widgets and make that your homepage. To use this widget area just a create a Page like normal. Then look for the dropdown menu marked "Template" and select "Widget Page" or "Widget Page: No Sidebars". If you want this to be your homepage, click on "Reading" under the "Settings" menu. Under "Front Page Displays" choose "A Static Page", and select the page you created. "Save Changes" and you're ready to go.
    *   ### Contact: Under Main

        Located on any individual contact page, under the contact information

    *   ### Company: Under Main

        Located on any individual company page, under the contact information</ol>

    ## Widgets

    Most standard WordPress widgets don't make sense for RoloPress. So we packed RoloPress with 8 new ones, and removed some that didn't make sense.

    1.  ### Add Company Form

        Allows you to add a Company from the front-end of RoloPress.

    2.  ### Add Contact Form

        Allows you to add a Contact from the front-end of RoloPress.

    3.  ### Companies

        Lists your Companies as a cloud or a list.

    4.  ### Company Details

        Displays the details for an individual company. This is a *Smart Widget*, which means it only displays when it's supposed to. A good place to place this widget is the Primary or Secondary sidebars, or Company:Under Main. This widget will only display when you view an individual company page.

    5.  ### Contact Details

        Displays the details for an individual contact. This is a *Smart Widget*, which means it only displays when it's supposed to. A good place to place this widget is the Primary or Secondary sidebars, or Contact:Under Main. This widget will only display when you view an individual conact page.

    6.  ### Owners

        When you create an items, or write a note, you are the owner of that item. This widget shows all owners and links to an owners page.

    7.  ### Recent Items

        Lists all recent items created and links to their individual pages.

    8.  ### Recent Notes

        Displays the most recent notes entered in RoloPress, for all items.

    ## Dynamic Contextual Body Classes

    RoloPress makes use of the dynamic contextual class functions developed by Scott Wallick and Andy Skelton for [The Sandbox][3], with some additions developed by Justin Tadlock for [The Hybrid Theme][4]. These functions make RoloPress almost endlessley customizable through <abbr title="Cascading Stylesheets">CSS</abbr> alone.

    To really see how these classes work, where they appear and how you can use them, I recommend the Firefox extension, [Firebug][5].

    ## RoloPress Support

    If you have a question, problem or suggestion for RoloPress please use [our Forums.][6]

    The latest RoloPress version, updates and bug fixes are always available at the [RoloPress Project on Github][7].

    ## Credit and Inspiration

    A special thanks goes out to those who helped and inspired us, directly or indirectly:

    *   [Sandbox Theme][3] (of course)
    *   [Justin Tadlock][8]
    *   [Ian Stewart][9]
    *   [Artisan Themes][10]

    ## Copyright & License

    Copyright(c) [SlipFire LLC.][11] and [Sudar Muthu][12].
    All rights reserved.

    Released under the GPL license.

    You may not use this file except in compliance with the License.</br> You may obtain a copy of the License at:

    <http://www.opensource.org/licenses/gpl-license.php>

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

    <em class="thankyou">Thank you</em>.

 [1]: http://rolopress.com/themes/rolopress-default-theme
 [2]: http://themeshaper.com/functions-php-wordpress-child-themes/
 [3]: http://www.plaintxt.org/themes/sandbox/
 [4]: http://www.themehybrid.com
 [5]: http://www.getfirebug.com/
 [6]: http://rolopress.com/forums/
 [7]: http://github.com/rolopress
 [8]: http://justintadlock.com/
 [9]: http://themeshaper/
 [10]: http://artisanthemes.com/themes/wp-contact-manager/
 [11]: http://slipfire.com/
 [12]: http://sudarmuthu.com