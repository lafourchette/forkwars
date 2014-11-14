# Forkwars

Forkwars is a turn by turn strategy game based on the Intelligence System success Advance Wars.

Read more about it on http://en.wikipedia.org/wiki/Advance_Wars

The game provide an environment where one can develop and test AI code, against self or other
competitors.

## Requirements
GNU make

## Installing

```bash
make install
```

You can serve the root folder and have a look at the viewer.php file.

## Testing

Make sure you have phpunit installed somewhere in your PATH. Just run phpunit in the root folder.

```bash
phpunit

# and...
php -S localhost:8000
# navigate to localhost:8000/viewer.php
```

## Contributing

Fill or solve [issues](https://github.com/lafourchette/forkwars/issues).

## Hall Of Fame

[rodrigue67](https://github.com/rodrigue67)

## Insights

If you want to create a General, you need to understand a few core concepts.

A World holds two types of objects : Terrains and Units. For example, Forest is a Terrain and Infantry is an Unit.
Your General is given a World instance on which he can search for these objects.

He can then perform Actions on these object, say Infantry shall Capture an Headquarter.

In a client context, these Actions are recorded by the Game instance and sent to the server.

