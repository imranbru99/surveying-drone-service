# -*- coding: utf-8 -*-
"""Atomic AeroGrid Survey apply — write all brand files then exit."""
from pathlib import Path
import subprocess
import os
import json

ROOT = Path(__file__).resolve().parents[1]

def w(rel, content):
    path = ROOT / rel
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(content, encoding='utf-8', newline='\n')
    print('W', rel)

# Import large contents from sibling files if present; else inline critical ones
from finalize_files import FILES  # noqa

for rel, content in FILES.items():
    w(rel, content)

# composer.json name/description
cj = ROOT / 'composer.json'
data = json.loads(cj.read_text(encoding='utf-8'))
data['name'] = 'imranbru99/surveying-drone-service'
data['description'] = 'AeroGrid Survey — Laravel 13 + Filament 3 website, ERP, and AI for US surveying drone / photogrammetry services.'
data['keywords'] = ['laravel', 'filament', 'drone-survey', 'photogrammetry', 'erp', 'aerogrid']
cj.write_text(json.dumps(data, indent=4) + '\n', encoding='utf-8', newline='\n')
print('composer ok')

# Fix .env APP_NAME without wiping key
env = ROOT / '.env'
if env.exists():
    t = env.read_text(encoding='utf-8')
    import re
    t = re.sub(r'APP_NAME="[^"]+"', 'APP_NAME="AeroGrid Survey"', t, count=1)
    t = t.replace('fly@aerogridsurvey.com', 'hello@aerogridsurvey.com')
    t = t.replace('hello@skydatum', 'hello@aerogridsurvey')
    env.write_text(t, encoding='utf-8', newline='\n')

# migrate seed
os.chdir(ROOT)
r = subprocess.run(['php', 'artisan', 'migrate:fresh', '--seed', '--force'], capture_output=True, text=True)
print(r.stdout[-800:] if r.stdout else '')
print(r.stderr[-400:] if r.stderr else '')
print('exit', r.returncode)

# verify
v = subprocess.run(['php', 'artisan', 'tinker', '--execute', "echo \\App\\Models\\Setting::getValue('company_name');"], capture_output=True, text=True)
print('setting:', v.stdout.strip(), v.stderr.strip()[:200])
