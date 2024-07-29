
## SYNOLOGY_INTEGRATED_WITH_PHP_FOR_AUTOMATION

as a note to myself

```bash
$this->post_nas_synologi( "http://xxx:0000/webapi/entry.cgi", "_sid", "_did", "/path/to/or/create/folder", "itsmypicture.jpg", file_get_contents(path/to/itsmypicture.jpg), mime_content_type(path/to/itsmypicture.jpg) );
```

```bash
$this->post_delete_nas_synologi( "http://xxx:0000/webapi/entry.cgi", "_sid", "/path/to/delete/file/or/folder" );
```

