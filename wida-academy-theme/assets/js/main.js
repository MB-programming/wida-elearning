/**
 * Wida Academy - Main JavaScript
 * أكاديمية وايدا - الملف الرئيسي للجافاسكريبت
 */

(function ($) {
  'use strict';

  // =============================================
  // DOM Ready
  // =============================================
  $(document).ready(function () {
    widaInit();
    widaNavHighlight();
    widaAnimateStats();
    widaSearchInit();
  });

  // =============================================
  // Initialize
  // =============================================
  function widaInit() {
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const siteNav = document.querySelector('.site-nav');

    if (menuToggle && siteNav) {
      menuToggle.addEventListener('click', function () {
        siteNav.classList.toggle('nav-open');
        this.classList.toggle('active');
      });
    }

    // Smooth scroll for anchors
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    // Card hover effects
    document.querySelectorAll('.course-card, .doc-card, .news-card').forEach(function (card) {
      card.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-4px)';
      });
      card.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
      });
    });
  }

  // =============================================
  // Nav Active Highlight
  // =============================================
  function widaNavHighlight() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.site-nav a').forEach(function (link) {
      const linkPath = new URL(link.href, window.location.origin).pathname;
      if (linkPath === currentPath || (currentPath !== '/' && linkPath !== '/' && currentPath.startsWith(linkPath))) {
        link.classList.add('active');
      }
    });
  }

  // =============================================
  // Animate Stats Counter
  // =============================================
  function widaAnimateStats() {
    const stats = document.querySelectorAll('.stat-info h3');
    if (!stats.length) return;

    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    stats.forEach(function (stat) {
      observer.observe(stat);
    });
  }

  function animateCount(element) {
    const target = parseInt(element.textContent) || 0;
    if (target === 0) return;
    const duration = 1000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(function () {
      current += step;
      if (current >= target) {
        element.textContent = target;
        clearInterval(timer);
      } else {
        element.textContent = Math.floor(current);
      }
    }, 16);
  }

  // =============================================
  // Search Functionality
  // =============================================
  function widaSearchInit() {
    const searchInput = document.getElementById('widaSearch');
    if (!searchInput) return;

    let searchTimeout;
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      const query = this.value.trim();

      if (query.length < 2) {
        document.getElementById('searchResults').innerHTML = '';
        return;
      }

      searchTimeout = setTimeout(function () {
        widaAjaxSearch(query);
      }, 400);
    });
  }

  function widaAjaxSearch(query) {
    if (!window.widaAjax) return;

    $.ajax({
      url: widaAjax.ajaxurl,
      type: 'POST',
      data: {
        action: 'wida_search',
        query: query,
        nonce: widaAjax.nonce,
      },
      success: function (response) {
        if (response.success) {
          renderSearchResults(response.data);
        }
      },
    });
  }

  function renderSearchResults(results) {
    const container = document.getElementById('searchResults');
    if (!container) return;

    if (!results.length) {
      container.innerHTML = '<p style="text-align:center; padding:20px; color:#9CA3AF;">لا توجد نتائج مطابقة</p>';
      return;
    }

    let html = '<div style="display:grid; gap:12px;">';
    results.forEach(function (item) {
      html += `
        <a href="${item.url}" style="display:flex; align-items:center; gap:12px; padding:12px 16px; background:#fff; border-radius:8px; border:1px solid #E5E0F5; transition:all 0.2s; color:inherit;">
          <span style="color:#6B35D9; font-size:18px;">${item.icon}</span>
          <div>
            <div style="font-weight:600; font-size:14px; color:#2D1B69;">${item.title}</div>
            <div style="font-size:12px; color:#9CA3AF;">${item.type}</div>
          </div>
        </a>`;
    });
    html += '</div>';
    container.innerHTML = html;
  }

  // =============================================
  // Notifications / Toast
  // =============================================
  window.widaToast = function (message, type) {
    type = type || 'success';
    const colors = {
      success: { bg: '#F0FDF4', border: '#BBF7D0', text: '#16A34A', icon: '✅' },
      error:   { bg: '#FEF2F2', border: '#FECACA', text: '#DC2626', icon: '❌' },
      info:    { bg: '#EFF6FF', border: '#BFDBFE', text: '#2563EB', icon: 'ℹ️' },
    };
    const c = colors[type] || colors.success;

    const toast = document.createElement('div');
    toast.style.cssText = `
      position: fixed; top: 80px; left: 20px; z-index: 9999;
      background: ${c.bg}; border: 1px solid ${c.border}; color: ${c.text};
      padding: 12px 20px; border-radius: 10px; font-size: 14px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      display: flex; align-items: center; gap: 8px;
      animation: slideIn 0.3s ease; font-family: 'Cairo', sans-serif;
    `;
    toast.innerHTML = `${c.icon} ${message}`;
    document.body.appendChild(toast);

    setTimeout(function () {
      toast.style.opacity = '0';
      toast.style.transition = 'opacity 0.3s ease';
      setTimeout(function () { toast.remove(); }, 300);
    }, 3000);
  };

  // =============================================
  // Filter Tabs
  // =============================================
  document.querySelectorAll('[data-filter-tab]').forEach(function (tab) {
    tab.addEventListener('click', function () {
      const filter = this.dataset.filterTab;
      const group = this.closest('[data-filter-group]');

      group.querySelectorAll('[data-filter-tab]').forEach(function (t) {
        t.classList.remove('active');
      });
      this.classList.add('active');

      document.querySelectorAll('[data-filter-item]').forEach(function (item) {
        if (filter === 'all' || item.dataset.filterItem === filter) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

})(jQuery || { ready: function(fn) { document.addEventListener('DOMContentLoaded', fn); }, ajax: function() {} });
