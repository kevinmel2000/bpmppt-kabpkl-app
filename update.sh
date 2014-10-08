#!/bin/sh

if [ ! -d backups ]; then
    mkdir backups
fi

now="$(date +'%Y-%m-%d')"
bdir="backups/app-$now"

if [ ! -d "$bdir" ]; then
    echo "\033[01;32m✔ \033[00mCreating \033[01;34m$bdir \033[00mdirectory"
    mkdir "$bdir"
fi

wget -O - --progress=bar:force https://codeload.github.com/feryardiant/bpmppt/tar.gz/bpmppt | tar xz
echo "\033[01;32m✔ \033[00mDownload and Extract new updates"

for oldee in  application asset system index.php package.json database.sql LICENSE README.md; do
    if [ -d "$oldee" ] && [ "$oldee" != 'bpmppt-bpmppt' ] && [ "$oldee" != 'backups' ]; then
        cp -rf "$oldee" "$bdir"
        rm -rf "$oldee"
        cp -rf bpmppt-bpmppt/"$oldee"/ .
        echo "\033[01;32m✔ \033[01;34m$oldee \033[00mdirectory has been Updated"
    elif [ -f "$oldee" ] && [ "$oldee" != 'appconfig.php' ] && [ "$oldee" != 'install.sh' ]; then
        cp "$oldee" "$bdir"
        rm "$oldee"
        cp bpmppt-bpmppt/"$oldee" .
        echo "\033[01;32m✔ \033[01;34m$oldee \033[00mfile has been Updated"
    fi
done
unset oldee


