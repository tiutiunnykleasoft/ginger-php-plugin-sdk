# Ginger Plugin SDK

This library is custom developed for Ginger API, based on schemas from API. <br>
Should be used with payment plugins or for order creation. <br>

## Available functionality :
- Creation Order entity with all related entities.
- Post the new order to Ginger API.

## Overview : 

## Entities Overview
    - Transactions
      - Transaction
        - Payment Method 
        - [Payment Method Details](#payment-method-details)
    - Description
    - Amount
    - Customer
      - DateOfBirth
      - Address
        - Country 
    - Order Lines
      - Line
    - Extra 
    - Client

#### Payment Method Details

<i>This entity contains additional payload for payment method, such as issuer id, hosted fields data <br>
or data for recurring payments.</i>

- For now, only string types of attributes values are supported.