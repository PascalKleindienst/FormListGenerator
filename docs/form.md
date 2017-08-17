# Forms
## Defining form fields
Form fields are defined with the YAML file. The file name doesn't matter, but fields.yaml and form_fields.yaml are common names.

```yaml
# ===================================
#  Form Field Definitions
# ===================================

fields:
    blog_title:
        label: Blog Title
        description: The title for this blog

    published_at:
        label: Published date
        description: When this blog post was published
        type: date

    [...]
```

### Field options
For each field you can specify these options (where applicable):

| **Option**      | **Description**                                                                                       |
|-----------------|-------------------------------------------------------------------------------------------------------|
| label           | a name when displaying the form field to the user.                                                    |
| type            | defines how this field should be rendered (see Available fields types below) Default: text.           |
| size            | specify the form field size. Options: half, full Default: full                                        |
| placeholder     | if the field supports a placeholder value.                                                            |
| comment         | places a descriptive comment below the field.                                                         |
| default         | specifies the default value for the field.                                                            |
| cssClass        | assigns a CSS class to the field container.                                                           |
| readOnly        | prevents the field from being modified. Options: true, false.                                         |
| disabled        | prevents the field from being modified and excludes it from the saved data. Options: true, false.     |
| required        | places a red asterisk next to the field label to indicate it is required.                             |
| attributes      | specify custom HTML attributes to add to the form field element.                                      |

## Available field types
There are various native field types that can be used for the type setting

### Text

`text` - renders a single line text box. This is the default type used if none is specified.

```yaml
blog_title:
    label: Blog Title
    type: text
```

### Email
`email` - renders a single line email field.

```yaml
mail:
    label: E-Mail
    type: email
```

### Bumber
`number` - renders a number field.

```yaml
mail:
    label: Age
    type: number
```

### Password

`password` - renders a single line password field.

```yaml
user_password:
    label: Password
    type: password
```

### Date

`date` - renders a text field used for selecting dates

```yaml
published_at:
    label: Published
    type: date
```

### Textarea

`textarea` - renders a multiline text box

```yaml
blog_contents:
    label: Contents
    type: textarea
```

### File Upload

`file` - renders a file upload

```yaml
file:
    label: Attachment
    type: file
```

`image` - renders a file upload which only accepts images and displays the image record

```yaml
avatar:
    label: Avatar
    type: image
```

### Dropdown

`dropdown` - renders a dropdown with specified options. There are 2 ways to provide the drop-down options. The first method defines options directly in the YAML file:

```yaml
status_type:
    label: Blog Post Status
    type: dropdown
    options:
        draft: Draft
        published: Published
        archived: Archived
```

The second method defines options with a PHP callable. This method should return an array of options in the format `key => label`.

```yaml
status_type:
    label: Blog Post Status
    type: dropdown
    options: getStatusTypeOptions
```

Supplying the dropdown options in the model class:

```php
function getStatusTypeOptions()
{
    return ['all' => 'All', ...];
}
```

### Radio List

`radio` - renders a list of radio options, where only one item can be selected at a time.

```yaml
security_level:
    label: Access Level
    type: radio
    options:
        all: All
        registered: Registered only
        guests: Guests only
```

Radio lists support two ways of defining the options, exactly like the dropdown field type.

### Checkbox

`checkbox` - renders a single checkbox.

```yaml
show_content:
    label: Display content
    type: checkbox
    default: true
    comment: Display the content # Comment which is displayed after the checkbox
```

### Checkbox List

`checkboxlist` - renders a list of checkboxes.

```yaml
permissions:
    label: Permissions
    type: checkboxlist
    options:
        open_account: Open account
        close_account: Close account
        modify_account: Modify account
```
Checkbox lists support two ways of defining the options, exactly like the dropdown field type.

### Section

`section` - renders a section heading and subheading. The `label` and `comment` values are optional and contain the content for the heading and subheading.

```yaml
user_details_section:
    label: User details
    type: section
    comment: This section contains details about the user.
```

### Partial

`partial` - renders a partial. Inside the partial these variables are available: `$value` is the default field value, `$this` is the configured class object `PascalKleindienst\FormListGenerator\Fields\PartialHTMLField`.

```yaml
content:
    type: partial
    path: ~/acme/blog/models/comments/_content_field.htm
```
