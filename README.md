Riverside commans Task Drupal Project
Project Overview

This project is built on Drupal and includes a custom Program content management solution, Views integration, taxonomy-based filtering, custom REST APIs, theming, accessibility improvements, and SEO enhancements.

Environment Setup
Prerequisites
DDEV
Docker
Composer
Drush
Installation Steps
1. Start DDEV
ddev start
2. Install Dependencies
ddev composer install
3. Import Database

Database file location:

sites/default/files/db/bizfinlabs.sql

Import database:

ddev import-db --src=sites/default/files/db/bizfinlabs.sql
4. Import Configuration

Configuration sync directory:

sites/default/files/config/sync

Run deployment:

ddev drush deploy -y
5. Access Site
ddev launch

Site should now be ready.

Implemented Features
Program Content Type

Created a custom Program content type with all required fields configured.

Features include:

Program title
Program category taxonomy reference
Program image/media fields
Program description/content fields
Additional required business fields as per requirements
Program Listing View

Created a View for Program content.

Features
Program listing page
Required fields added to display
Sorting and filtering configured
Exposed Filters

Installed and configured:

Better Exposed Filters module

Configured taxonomy-based exposed filtering:

Program Category taxonomy filter
User-friendly exposed filter UI
Related Programs Block

Created an additional View display used as a block.

Contextual Filters

Configured:

1. Content: ID

Default Value:

Content ID from URL

Purpose:

Excludes current node from related content listing.

2. Content: Has Taxonomy Term ID

Default Value:

Taxonomy Term ID from URL

Purpose:

Displays programs sharing the same taxonomy category as the current node.
Block Placement
Block placed on Program detail page.
Uses same card/twig design as main Program listing.
Custom Theme

Created custom theme:

riverside
Theme Features
Libraries

Configured:

riverside.libraries.yml

Includes:

Custom CSS
Custom JavaScript
Frontend Development

Implemented:

Page styling
Component styling
Responsive layouts
Program card layouts
View templates
Custom REST API Module

Created custom module providing REST resources.

Features

Custom JSON API endpoint for Program content.

REST Resource

Provides:

Program listing data
Program detail data
Structured JSON response
Benefits
Headless/API consumption ready
Custom response formatting
Drupal REST integration
Accessibility Improvements

Implemented accessibility enhancements including:

Mobile Navigation
Keyboard accessibility support
Improved navigation behavior
Better screen reader compatibility
Mobile menu accessibility improvements
SEO Enhancements

Installed and configured:

Pathauto

Used for:

Automatic URL aliases

Example:

/program/example-program
Metatag Module

Configured:

Meta tag
Schema.org / JSON-LD

Configured structured data support:

JSON-LD implementation
Schema.org metadata
Improved search engine visibility
Configuration Locations
Configuration Sync
sites/default/files/config/sync
Database Backup
sites/default/files/db/bizfinlabs.sql
Modules Used
Contributed Modules
Better Exposed Filters
Pathauto
Metatag
Schema.org Metatag
REST
Serialization
Custom Modules
Custom REST Resource Module
Custom Theme
riverside

1. Code Security
As per this Task, you Told me to push all the code on Git by creating public repository rather then private. Due to public directory, anyone can access this assignment(code, DB, etc.). I can make it private and then i can grant you an access for security reason.

2. Figma
Improve Figma design, i do not understand that exactly where i need to add hover effect, what would be font color on hover

3. REST API Requirements

Current implementation provides Program content via custom REST resource.

Please confirm:

Are additional fields required in API response?
Is pagination required?
Is authentication required for API access?

4. SEO Requirements

Current setup includes:

Metatag
Pathauto
JSON-LD


Flags
Configuration Storage

Configuration sync directory is currently stored in:

sites/default/files/config/sync

Recommended for long-term maintenance:

config/sync

outside public files directory.

Database Backup

Database dump included:

sites/default/files/db/bizfinlabs.sql

Ensure latest production-ready dump is used before deployment.

API Documentation

Custom REST resource is implemented, but detailed endpoint documentation may be required for frontend integration.


Deployment Commands
ddev start

ddev composer install

#import database || 

ddev drush sql-cli < sites/default/files/db/bizfinlabs.sql

ddev drush deploy -y

After deployment, clear caches if required:

ddev drush cr
