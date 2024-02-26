# Statamic Deduplication Addon

Elevate your Statamic project with the Deduplication addon—a game-changing tool designed to streamline your content management.

Say goodbye to the hassle of managing duplicate entries across various collections, thanks to this addon's innovative approach to organizing entry IDs.

It's the perfect solution for keeping your project's content clean, consistent, and captivating.  

Ideal for any project aiming to enhance efficiency and ensure a seamless user experience, the Deduplication addon is your key to a polished and professional Statamic site.

## Installation Guide

To integrate the Deduplication addon into your Statamic project, execute the following command in your project's root directory:

```bash
composer require tv2regionerne/statamic-deduplicate
```

## Usage Instructions
Activate deduplication by setting the deduplicate parameter to true within the collections tag in your templates.

Here’s how to apply it:

Usage is ```{{ collection:handle deduplicate="true" }}```

With deduplication enabled, the collection tag is enhanced to automatically filter out any previously fetched entries from other collection tags that also have deduplication active.  
This ensures your collections are free from duplicate entries, maintaining the integrity and uniqueness of your content in a simple an automated way.
