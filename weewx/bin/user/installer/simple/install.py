# $Id: install.py 1237 2015-02-02 03:22:06Z mwall $
# installer for simple
# Copyright 2014 Matthew Wall

from setup import ExtensionInstaller

def loader():
    return SimpleInstaller()

class SimpleInstaller(ExtensionInstaller):
    def __init__(self):
        super(SimpleInstaller, self).__init__(
            version="0.4",
            name='simple',
            description='A minimalist layout.',
            author="Matthew Wall",
            author_email="mwall@users.sourceforge.net",
            config={
                'StdReport': {
                    'simple': {
                        'skin':'simple',
                        'HTML_ROOT':'simple'}}},
            files=[('skins/simple',
                    ['skins/simple/index.html.tmpl',
                     'skins/simple/skin.conf'])
                   ]
            )
