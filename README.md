### Overview
This page was designed to convert EM4100 RFID codes between various formats. It should be capable of converting all EM and HID cards 26-44 bit. If you find a format that is missing please let me know.

***

### Data Formats
#### ID Number
This is the long number typically printed on the card.  Other output formats may only be partially available when entering data with this format. Example format: `0011200655`

#### HID Format
This is the facility/pin numbers typically printed on the card. When using these numbers to do conversions you will need to separate the two numbers with a non-numeric character such as a space, slash, or comma. Other output formats may only be partially available when entering data with this format. `170,59535`, `170 59535`, and `170/59535` are all valid formats.

#### Hexadecimal
This is the Hex version of the card number. Typically USB readers will return this format. This may also be printed on the card. Using this format will fully populate all output types. Example format: `FBECAAE88F`

#### Decimal
This format is rarely used, but it may still be useful to have. Using this format will fully populate all output types. Example Format: `1082007414927`

#### Binary
This format is typically never seen, however this is extremely useful for determining key values with unusual security panels. If you can't figure out how your system addresses cards, take a known working card and enter the HEX value and use the binary data to compare the binary value of the scanned data. Using this format will fully populate all output types. Example format: `1111101111101100101010101110100010001111`
t
