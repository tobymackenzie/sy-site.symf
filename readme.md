Symfony Site
======

Some base functionality for use with Symfony sites.  Currently provides:

- HTML shell templates with a controller to help pass in required data
- a command to call `phpinfo()` from the console

May move some of this stuff to "sy-web.symf" project.  May add more to be a more fully functional site.

Has a bundle `TJM\SySite\TJMSySiteBundle` to easily load templates / config with `@TJMSySite` / `@TJMSySiteBundle` path prefix.
