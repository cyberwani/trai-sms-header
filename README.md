# TRAI SMS Header

**TRAI SMS Header** is a PHP library and CLI tool developed by [Cyberwani](https://github.com/Cyberwani)  
for inspecting and decoding TRAI-compliant SMS headers under TCCCPR 2025 guidelines.

It helps telecom developers, SMS gateway providers, and compliance teams to easily parse  
headers such as `VM-ABCDEF-S` into detailed information like **Operator**, **Circle**, **Sender Name**, and **Message Type**.

---

## 🚀 Features

- 🔍 Parse and validate TRAI SMS headers (`VM-ABCDEF-S`, `VK-MYCOMP-P`, etc.)
- 🏢 Lookup registered **Sender Names** via included `sender-list.json`
- 🛰️ Identify Operator & Circle based on TRAI prefix mapping
- 💬 Detect message type suffix (`-P`, `-S`, `-T`, `-G`)
- 🧩 Works as a **Composer library** *and* a **CLI tool**
- ⚡ Lightweight, dependency-free (optional PhpSpreadsheet for data import)

---

## 🧰 Installation

Install via [Composer](https://getcomposer.org):

```bash
composer require cyberwani/trai-sms-header
```

This will install both the PHP library and the CLI binary:
```
vendor/bin/trai-sms-header
```

----------

## 🧑‍💻 PHP Usage Example

```php
<?php
require 'vendor/autoload.php';

use Cyberwani\TRAI_SMS_Header\TRAI_SMS_Header;

// Initialize with default sender-list.json (included in package)
$trai = new TRAI_SMS_Header();

// You can also provide a custom sender JSON file if desired:
// $trai = new TRAI_SMS_Header('/path/to/custom-sender-list.json');

$result = $trai->inspect('VM-ABCDEF-S');

print_r($result);
```

**Output:**
```php
Array
(
    [input] => VM-ABCDEF
    [prefix] => VM
    [operator_code] => V
    [operator] => Vodafone Idea Ltd
    [circle_code] => M
    [circle] => Mumbai
    [sender_id] => ABCDEF
    [sender_name] => ABCDEF ENTERPRISES PVT LTD
    [suffix] => -S
    [message_type] => Service
    [valid] => 1
)
```
----------

## 💻 CLI Usage

After installing via Composer, run directly from terminal:

```bash
vendor/bin/trai-sms-header <HEADER> [--file=/path/to/sender-list.json] [--json]
```

### Examples

#### 1️⃣ Standard CLI output

```bash
vendor/bin/trai-sms-header VM-ABCDEF-S
```

**Output:**

```
🔍 TRAI SMS Header Inspection
──────────────────────────────
Header:       VM-ABCDEF-S
Prefix:       VM
Operator:     Vodafone Idea Ltd (V)
Circle:       Mumbai (M)
Sender ID:    ABCDEF
Sender Name:  ABCDEF ENTERPRISES PVT LTD
Message Type: Service
Suffix:       -S
Valid:        Yes
──────────────────────────────
```

#### 2️⃣ JSON output (for scripts or API integrations)

```bash
vendor/bin/trai-sms-header VM-ABCDEF-S --json
```

**Output:**

```json
{
  "input": "VM-ABCDEF",
  "prefix": "VM",
  "operator_code": "V",
  "operator": "Vodafone Idea Ltd",
  "circle_code": "M",
  "circle": "Mumbai",
  "sender_id": "ABCDEF",
  "sender_name": "ABCDEF ENTERPRISES PVT LTD",
  "suffix": "-S",
  "message_type": "Service",
  "valid": true
}
```

#### 3️⃣ Using a custom sender list

```bash
vendor/bin/trai-sms-header VM-MYCOMP-T --file=/tmp/custom-sender-list.json
```

----------

## ⚙️ Default Data Source

The package ships with:

```
src/Data/sender-list.json
src/Data/operator-map.php
src/Data/circle-map.php
```

If you don’t provide a custom JSON file, the library automatically uses the bundled `sender-list.json`.

You can regenerate or update this JSON file using TRAI’s official header data  
(see future command `build-json` for automated import from XLSX or CSV).

----------

## 🧱 JSON Structure (sender-list.json)

Simple and fast key:value lookup format:

```json
{
  "ABCDEF": "ABCDEF ENTERPRISES PVT LTD",
  "MYCOMP": "MyCompany Technologies LLP",
  "TESTIN": "Testing Solutions India"
}
```

----------

## 🧩 Namespace and Class
| Namespace | Class Name |Example|
|:----------|:----------|:---------|
| `Cyberwani\TRAI_SMS_Header`|`TRAI_SMS_Header`|`new TRAI_SMS_Header();`|

----------
## 🧾 License

Licensed under the **MIT License**.  
© 2025 Cyberwani — All rights reserved.

----------

## 🧑‍💼 Author

**Cyberwani**  
🔗 [https://github.com/cyberwani](https://github.com/cyberwani)

## 💡 Coming Soon

-   `build-json` CLI subcommand to auto-generate sender-list.json from XLSX/CSV
-   Web-based UI for header validation
-   Integration testing suite