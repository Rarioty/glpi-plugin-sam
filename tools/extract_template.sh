#!/bin/bash

soft='GLPI plugin sam'
version='1.0.0'
email=julien.faucheux@orange.com
copyright='Orange S.A.'

find . -iname "*.php" | xargs xgettext -o locales/sam.pot -L PHP --add-comments=TRANS --from-code=UTF-8 --force-po --keyword=_n:1,2 --keyword=__s --keyword=__ --keyword=_e --keyword=_x:1c,2 --keyword=_ex:1c,2 --keyword=_sx:1c,2 --keyword=_nx:1c,2,3 --keyword=_sn:1,2