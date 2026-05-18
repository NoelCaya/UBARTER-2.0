# UBarter Images Directory

This directory contains all the images used throughout the UBarter system.

## Required Images

### 1. **ub-logo.png** (UB Seal Logo)
- **Location**: `public/images/ub-logo.png`
- **Purpose**: Used in the navbar across all pages
- **Dimensions**: 512x512px (recommended)
- **Format**: PNG with transparency
- **Description**: The University of Batangas circular seal logo with "INSTITUTIO", "PIETAS", "AESTHETICA", "ET DEUS", "PATRIA" text and cross symbol

### 2. **university-bg.png** (University Background)
- **Location**: `public/images/university-bg.png`
- **Purpose**: Used as background image on the login page
- **Dimensions**: 1920x1080px (minimum) or higher
- **Format**: PNG or JPG
- **Description**: The cartoon illustration of students with "UNIVERSITY OF BATANGAS" and "Batangas City Campus" text

## How to Add Images

1. Save the UB seal logo as `ub-logo.png` in this directory
2. Save the university illustration as `university-bg.png` in this directory
3. The images will automatically be used in:
   - **ub-logo.png**: Navigation bar on all authenticated pages
   - **university-bg.png**: Login page background

## Current References

- Navbar: `resources/views/components/navbar.blade.php`
- Login: `resources/views/auth/login.blade.php`
