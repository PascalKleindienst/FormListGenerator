# List
## Configuring the list behavior

The configuration fileis defined in YAML format. The file name doesn't matter, but the list.yaml and list_config.yaml are common names. Below is an example of a typical list behavior configuration file:

```yaml
# ===================================
#  List Behavior Config
# ===================================
recordUrl: /acme/blog/posts/update/:id
noRecordsMessage: Could not find any records
customViewPath: ~/views

columns:
  full_name: 
    label: Full Name
    type: text
    clickable: true
  age:
    label: Age
    type: Number
    default: 9000
  created_at:
    label: Created At
    type: date
    format: M j, Y
```

| **Option**       | **Description**                                                                                                                                                                |
|------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| recordUrl        | link each list record to another page. *Eg: `users/update:id`. The `:id` part is replaced with the id attribute of the record. This allows you to link the list and the form.* |
| noRecordsMessage | a message to display when no records are found, can refer to a localization string.                                                                                            |
| customViewPath   | specify a custom view path to override partials used by the list, optional.                                                                                                    |
| columns          | the columns which are displayed in the table.                                                                                                                                  |

## Defining list columns

List columns are defined in the same YAML file as the list configuration. The column configuration is used by the list behavior for creating the record table and displaying model columns in the table cells.

### Column Options
For each column can specify these options (where applicable):

| **Option** | **Description**                                                                                 |
|------------|-------------------------------------------------------------------------------------------------|
| label      | a name when displaying the list column to the user.                                             |
| type       | defines how this column should be rendered *(see Column types below)*.                          |
| default    | specifies the default value for the column if value is empty.                                   |
| clickable  | if set to false, disables the default click behavior when the column is clicked. Default: true. |
| cssClass   | assigns a CSS class to the column container                                                     |
| default    | specifies the default value for the column.                                                     |

## Available column types

There are various column types that can be used for the type setting, these control how the list column is displayed.

### Text

`text` - displays a text column, aligned left

```yaml
full_name:
    label: Full Name
    type: text
```

### Number

`number` - displays a number column, aligned right

```yaml
age:
    label: Age
    type: number
```

### Date

`date` - displays the column value as a formatted date. You can also specify a custom date format, for example Thursday 25th of December 1975:

```yaml
created_at:
    label: Date
    type: date
    format: l jS \of F Y
```

### Partial

`partial` - renders a partial. Inside the partial these variables are available:`$value` is the default cell value, `$record` is an array which contains the records for this row, `$this` is the configured class object `PascalKleindienst\FormListGenerator\Data\Column`.

```yaml
content:
    type: partial
    path: ~/plugins/acme/blog/models/comments/_content_column.htm
```
