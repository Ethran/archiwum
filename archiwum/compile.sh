#!/bin/bash

files="$(egrep '{{(.*?)}}' index.html)"

echo $files;
v="some string.rtf"
file=$files;
file=${file::-2}
file="${file:2}"
echo "$file"


file_path="index.html"
line="$(egrep -n '{{(.*?)}}' index.html)"
start_styles_line_num="$(egrep -n '{{(.*?)}}' |echo $line)"
echo "$start_styles_line_num"
next_line_num=$(($start_styles_line_num+1))
