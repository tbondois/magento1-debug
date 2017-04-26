# About TBD_Debug


Fork of [madalinoprea/magneto-debug](https://github.com/madalinoprea/magneto-debug) for Magento 1.9. It add a Debug toolbar on web pages (almost the same as the Symfony one) to increase productivity.

NOTE : This module should only be installed in dev environment, so module files should never be versionned inside a project.

## Quick install guide :

* copy files/folder from your project root

* Check that your .gitignore contains these lines (or add them) :

```ignore
#### TBD_Debug toolbar :
/README_Debug.md
/app/code/community/TBD/Debug/
TBD_Debug*
tbd_debug*
/dev/firephp/
```

* `magerun cache:flush`

* `magerun sys:setup:run`  to create the `tbd_debug_request_info` database table

* to disable report storage  in the the `tbd_debug_request_info` database table, enable it with a GET parameter `?nodbdebug=1`
(ie : `/index.php?nodbdebug=1` and ` /index.php/admin?nodbdebug=1` for adminhtml. It will keep being disabled until the session is gone or a `?nodbdebug=0` parameter in GET


## Quick disabling

Pour désactiver temporairement la barre en cas de problème : editer app/etc/modules/tbd_debug.xml, mettre <active>false</active> et re-cleaner les caches : la barre sera plus chargée

## Uninstall :

rm -rf README_Debug.md app/code/community/TBD/ app/design/adminhtml/base/default/layout/tbd_debug.xml app/design/adminhtml/base/default/template/tbd_debug/ app/design/frontend/base/default/layout/tbd_debug.xml app/design/frontend/base/default/template/tbd_debug/ app/etc/modules/TBD_Debug.xml skin/adminhtml/base/default/tbd_debug/ skin/frontend/base/default/tbd_debug/ dev/firephp/

## Fork Fixes

* no need of installation via modman. Just copy/paste files to your magento root path

* Insert in database table `tbd_debug_report_info` except on GET parameter ?nodbdebug=1, then the configuration is stored in session. You can also control in the Tools menu of the toolbar > Save Report in Db : Enable/Disable). It will have some side effects, like not displaying last/top request in the extended Panel of the toobar

* The dev toolbar now don't display a useless header

* Management of  current store URL in the toolbar links

* Look for `@fixes` to see all my changes

* Le block wishlist item n'est plus profilé, parce que ca faisait crasher magento. Il y a une explication pour rajouter d'autres exceptions en cas de crash sur d'autres pages.


## Hints

* Vous devrez voir une barre sur fond noir en bas des pages. L'onglet le plus intéressant est celui permettant de voir le des blocks et layout. Il y a moyen d'activer du profiling en db.

* *Template Hints : Enable* dans le menu a droite est bien pratique aussi pour voir le découpage des phtml et des blocks



# Features
- **Request and Controller information**: lists request attributes and controller that handled the request; captures request info for Ajax and POST requests
- **Execution Timeline**: shows execution timeline based on Varien Profiler timers
- **Logs**: shows log lines added to system and exception logs during a request
- **Events**: shows all events dispatched during request and observers that were called
- **Database**: lists all models and collections loaded during a request; when SQL profiler is enabled, lists all SQL queries executed and offers the ability to see their result or describe their execution plan
- **E-mails**: lists sent e-mails with preview
- **Layout**: outputs rendering tree, lists layout handlers loaded during current request and adds ability to see updated added by layout files to specific handle; offers information about instantiated and rendered blocks
- **Configuration**: lists available Magento modules with their status and their version;
 also offers the ability to enable/disable them
- **Toolbar Tools**: contains quick links to flush cache, enable template hints, enable SQL profiler, enable Varien Profiler, enable Magento Enterprise full page cache debug

Don't forget to check out [screenshots gallery](docs/images.md)

# Compatibility

[![Aggregated Build Status](https://travis-ci.org/madalinoprea/magneto-debug.svg)](https://travis-ci.org/madalinoprea/magneto-debug)

Extension is (hopefully) successfully unit tested against PHP 5.4, PHP 5.5 and Magento CE 1.9, Magento CE 1.8, Magento CE 1.7 and
their related Magento Enterprise versions.



# Common Issues

- `table tbd_debug_report_info doesn't exist` : The Magento data setup didn't run. Please read the "Quick install guide" section of this file.

- 'Mage Registry key already exists' exception is raised after installation
    - `Mage registry key "_singleton/debug/observer" already exists` is reported when cache regeneration was corrupted.
    Please try to flush Magento cache.

- Doesn'work. I see these logs on `var/log/system.log`: `Not valid template file:adminhtml/default/default/template/tbd_debug/toolbar.phtml`
    - If you installed the module using modman you've missed an important step. Search this page after 'Allow symlinks for the templates directory' and complete that step.

- I can't see toolbar.
    - Toolbar is displayed in these conditions:
        - module is installed and enabled
        - toolbar is enabled from Admin / System / Configuration / Advanced - Developer Debug Toolbar (by default it's enabled)
        - Magento is running in developer mode (MAGE_IS_DEVELOPER_MODE) 
		- Or your ip is listed under under 'Developer Client Restrictions'
    - Check that module name TBD_Debug is installed and enabled
    - Check that 'Allow Symlinks' configuration is enabled for Modman installation

- I can't see toolbar on specific page
    - Toolbar is added to all pages that have a structural block named `before_body_end`. By default this block is available on all Magento pages.
    Eliminate a possible cache problem by disabling all caches. Try to determine if there are any customizations that have removed `before_body_end`.


