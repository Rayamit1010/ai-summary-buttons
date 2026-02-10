# GitHub Repository Setup Guide

## 🚀 Step-by-Step GitHub Upload

### 1. Create Repository on GitHub

1. Go to https://github.com/new
2. Repository name: `ai-summary-buttons`
3. Description: `Add beautiful AI-powered summary buttons to WordPress - ChatGPT, Claude, Gemini, Perplexity & Grok`
4. **Public** repository (for open source)
5. **DO NOT** initialize with README (we already have one)
6. Click "Create repository"

### 2. Upload Files to GitHub

**Option A: Using GitHub Desktop (Easiest)**
1. Download GitHub Desktop: https://desktop.github.com/
2. Clone your new repository
3. Copy all files from the `github-repo` folder to the cloned directory
4. Commit: "Initial commit - v2.5.2"
5. Push to GitHub

**Option B: Using Command Line**
```bash
cd /path/to/github-repo
git init
git add .
git commit -m "Initial commit - AI Summary Buttons v2.5.2"
git branch -M main
git remote add origin https://github.com/Rayamit1010/ai-summary-buttons.git
git push -u origin main
```

**Option C: Upload via Web Interface**
1. Go to your repository on GitHub
2. Click "uploading an existing file"
3. Drag and drop all files from `github-repo` folder
4. Commit: "Initial commit - v2.5.2"

### 3. Create First Release

1. Go to repository → Releases → "Create a new release"
2. Tag: `v2.5.2`
3. Title: `AI Summary Buttons v2.5.2`
4. Description:
   ```
   Initial public release of AI Summary Buttons
   
   ✨ Features:
   - 5 AI services (ChatGPT, Claude, Gemini, Perplexity, Grok)
   - Full customization dashboard
   - Elementor widget support
   - Auto-insert functionality
   - Responsive design
   
   📥 Download the plugin ZIP file below
   ```
5. Upload: `ai-summary-buttons-2.5.2.zip` (create from github-repo folder)
6. Click "Publish release"

---

## 🔒 Repository Protection Settings

### Branch Protection Rules

1. Go to: Settings → Branches → Add rule
2. Branch name pattern: `main`
3. Enable:
   - ✅ Require pull request reviews before merging
   - ✅ Require status checks to pass
   - ✅ Require branches to be up to date
   - ✅ Include administrators

### Security Settings

1. **Settings → Security**
   - ✅ Enable Dependabot alerts
   - ✅ Enable Dependabot security updates
   - ✅ Enable private vulnerability reporting

2. **Settings → Code security and analysis**
   - ✅ Dependency graph
   - ✅ Dependabot alerts
   - ✅ Secret scanning

### Repository Settings

1. **General Settings**
   - ✅ Disable Wiki (if not needed)
   - ✅ Enable Issues
   - ✅ Enable Discussions (optional)
   - ✅ Restrict who can delete this repository

2. **Collaborators**
   - Add trusted contributors only
   - Use appropriate permission levels

---

## 📋 Repository Topics (Tags)

Add these topics to your repository for better discoverability:

```
wordpress, wordpress-plugin, ai, chatgpt, claude, gemini, 
perplexity, grok, artificial-intelligence, summary, buttons, 
php, javascript, elementor, shortcode, customizable
```

Go to: Repository → About (⚙️) → Topics

---

## 🏷️ Create Issue Templates

Create `.github/ISSUE_TEMPLATE/bug_report.md`:

```markdown
---
name: Bug report
about: Create a report to help improve the plugin
title: '[BUG] '
labels: bug
---

**Describe the bug**
A clear description of the bug.

**To Reproduce**
Steps to reproduce the behavior.

**Expected behavior**
What you expected to happen.

**Environment:**
- WordPress Version:
- PHP Version:
- Plugin Version:
- Theme:

**Screenshots**
If applicable, add screenshots.
```

Create `.github/ISSUE_TEMPLATE/feature_request.md`:

```markdown
---
name: Feature request
about: Suggest a feature for this plugin
title: '[FEATURE] '
labels: enhancement
---

**Feature Description**
Clear description of the feature.

**Use Case**
Why would this feature be useful?

**Proposed Solution**
How should this work?
```

---

## 📱 Social Preview Image

1. Create a 1280x640px image with:
   - Plugin name
   - Logo/icon
   - Brief description
   - AI service icons

2. Upload: Settings → Social Preview → Upload an image

---

## ✅ Post-Upload Checklist

- [ ] README.md displays correctly
- [ ] LICENSE file is present
- [ ] All plugin files uploaded
- [ ] First release created
- [ ] Branch protection enabled
- [ ] Topics/tags added
- [ ] Repository description set
- [ ] Issue templates created
- [ ] Security features enabled
- [ ] Social preview image added

---

## 🔗 Important URLs

After setup, your repository will have:

- **Repository:** `https://github.com/Rayamit1010/ai-summary-buttons`
- **Releases:** `https://github.com/Rayamit1010/ai-summary-buttons/releases`
- **Issues:** `https://github.com/Rayamit1010/ai-summary-buttons/issues`
- **Download:** `https://github.com/Rayamit1010/ai-summary-buttons/releases/download/v2.5.2/ai-summary-buttons.zip`

---

## 🎯 Next Steps

1. ✅ Upload to GitHub
2. ✅ Create first release
3. ✅ Enable protections
4. ✅ Post on LinkedIn
5. Share with WordPress community

**Need help? Open an issue or contact the maintainer!**
