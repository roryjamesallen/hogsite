# Hogipedia
Each page in the hogipedia is stored in one big JSON file:
```
"example-person": {
    "title": "Example Person",
    "category": "People",
    "image-caption": "Example Person outside [place]",
    "sections": {
      "Overview": "This is the overview of the example person. Example person is related to [other-person]",
      "Second Section": "This is a second section, for example the description of an event Example Person is famous for."
    }
}
```
- Other pages can be linked to using square brackets and their 'page handle'. The page-handle of the example page above is `example-person`. The link will be rendered as the page title when viewed.
- Pages can have up to one image. If `image-caption` is set, the image at `images/thompson-world/thompson-world-page-handle.png` is rendered with the caption beneath. Leave out `image-caption` entirely if the image doesn't exist.
- Any number of sections is allowed but only use a whole new section if there's enough to say about that one topic.
- Category should only be one of the existing ones, or if you really think a new one is needed then let Rory know.
