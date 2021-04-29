Disposable Technical Specs and Runways Module for phpVMS v7

This module is compatible with the latest dev build as of 28APR2021, there is no need to modify any default files.
Technically all blade files (views/pages or whatever you call them) should work with your template but they are mainly 
designed for Bootstrap compatible themes (like Disposable Themes, Stisla etc). 

So if something looks weird in your template then you need to edit them.

***** Manual Installation Steps 

Upload contents of the package (or pull/clone from GitHub) to your root/modules/DisposableTech folder
Go to admin section and enable the module, that's all
After enabling/disabling modules an app cache cleaning process IS necessary (check admin/maintenance)

***** Usage

This module does not have any standalone views/pages/blades. Disposable Theme and other Disposable Modules are capable of using its functions.

Module provides runway data and technical specifications to your flights/simbrief_form.blade, also to your aircraft details page when enabled.
Both data is pulled from Module Models by helper functions/methods when requested.

If you need an airport's runways you can get the collection with;

@php $runways = Dispo_GetRunways('LTAI') ; @endphp

or with

@php $runways = Dispo_GetRunways($airport->id) ; @endphp

according to your needs. Then you need to step through the $runways collection with a loop to display its contents.
(Similar logic applies to Aircraft/Subfleet Specs too)

*****

You are free to edit any of the files as you wish, but please do not expect help/updates for the code you edited (controllers and providers)
I always try to provide info and support but can not fix things you broke ;) Just share your thoughts about any improvements so we can think
together before changing things.

Enjoy,
Disposable
28.APR.2021