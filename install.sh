#!/bin/sh
echo "Downloading"
wget https://github.com/feryardiant/bpmppt/archive/bpmppt.tar.gz -O - | tar xz
echo "Updating application folder"
cp -rf bpmppt-bpmppt/application/ .
echo "Updating system folder"
cp -rf bpmppt-bpmppt/system/ .
echo "Updating asset folder"
cp -rf bpmppt-bpmppt/asset/ .
echo "Removing cache"
rm -rf bpmppt-bpmppt