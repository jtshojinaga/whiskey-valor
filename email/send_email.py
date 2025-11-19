import os
import sys
import json
import smtplib
from email.mime.text import MIMEText
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

SMTP_SERVER = os.getenv("SMTP_SERVER")
SMTP_PORT = int(os.getenv("SMTP_PORT", "587"))
SMTP_USER = os.getenv("SMTP_USER")
SMTP_PASS = os.getenv("SMTP_PASS")

def output_json(obj):
    print(json.dumps(obj))
    sys.stdout.flush()

def error(msg):
    output_json({"success": False, "sent": [], "failed": [], "error": msg})
    sys.exit(1)

# Read JSON input
try:
    raw_input = sys.stdin.read().strip()
    data = json.loads(raw_input)
    emails = data["emails"]
    sender_name = data.get("sender", "No Name")
    subject = data["subject"]
    body = data["body"]
except Exception as e:
    error(f"Invalid JSON input: {str(e)}")

def build_message(sender_name, to_email, subject, body):
    msg = MIMEText(body, "plain")
    msg["From"] = f"{sender_name} <{SMTP_USER}>"
    msg["To"] = to_email
    msg["Subject"] = subject
    return msg.as_string()

# Connect to SMTP
try:
    server = smtplib.SMTP(SMTP_SERVER, SMTP_PORT)

    # REMOVE DEBUG LOGGING
    server.set_debuglevel(0)

    server.starttls()
    server.login(SMTP_USER, SMTP_PASS)
except Exception as e:
    error(f"SMTP connection/login failed: {str(e)}")

sent = []
failed = []

for to_email in emails:
    try:
        msg = build_message(sender_name, to_email, subject, body)
        server.sendmail(SMTP_USER, to_email, msg)
        sent.append(to_email)
    except Exception as e:
        failed.append({"email": to_email, "error": str(e)})

server.quit()

# Return JSON result
output_json({
    "success": len(failed) == 0,
    "sent": sent,
    "failed": failed,
    "error": ""
})


