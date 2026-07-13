<style>
    .staynets-contract {
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 14px;
        line-height: 1.55;
        color: #111;
        background: #fff;
    }
    .staynets-contract__header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #2d8a3e;
        margin-bottom: 20px;
    }
    .staynets-contract__brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .staynets-contract__logo {
        width: 72px;
        height: auto;
        object-fit: contain;
    }
    .staynets-contract__brand-name {
        font-size: 28px;
        font-weight: 700;
        color: #2d8a3e;
        line-height: 1.1;
        margin: 0;
    }
    .staynets-contract__meta {
        text-align: right;
        font-size: 13px;
        color: #1a5fb4;
    }
    .staynets-contract__meta strong {
        display: block;
        font-size: 14px;
        color: #1a5fb4;
        margin-bottom: 4px;
    }
    .staynets-contract__title {
        text-align: center;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin: 0 0 16px;
    }
    .staynets-contract__intro {
        margin-bottom: 18px;
        white-space: pre-wrap;
    }
    .staynets-contract__section {
        margin-bottom: 16px;
    }
    .staynets-contract__section-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0 0 6px;
    }
    .staynets-contract__lead-in,
    .staynets-contract__closing,
    .staynets-contract__sig-note {
        margin: 0 0 6px;
    }
    .staynets-contract__section ul {
        margin: 0;
        padding-left: 0;
        list-style: none;
    }
    .staynets-contract__section li {
        margin-bottom: 4px;
        padding-left: 1.1em;
        position: relative;
    }
    .staynets-contract__section li::before {
        content: '-';
        position: absolute;
        left: 0;
    }
    .staynets-contract__signatures {
        margin-top: 20px;
        padding-top: 8px;
    }
    .staynets-contract__sig-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 12px;
    }
    .staynets-contract__sig-block {
        margin-bottom: 18px;
    }
    .staynets-contract__sig-label {
        font-weight: 700;
        margin-bottom: 4px;
    }
    .staynets-contract__sig-line {
        min-height: 48px;
        border-bottom: 1px dotted #666;
        margin-top: 8px;
        display: flex;
        align-items: flex-end;
        padding-bottom: 4px;
    }
    .staynets-contract__sig-line img {
        max-height: 70px;
        max-width: 240px;
        object-fit: contain;
    }
    .staynets-contract__footer-bar {
        background: #2d8a3e;
        color: #fff;
        text-align: center;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 16px;
        margin-top: 28px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .staynets-contract__footer-phone {
        text-align: center;
        font-size: 13px;
        margin-top: 8px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .staynets-contract__page-break {
        page-break-after: always;
        break-after: page;
        margin-bottom: 32px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #ccc;
    }
    @media print {
        .staynets-contract {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }
        .staynets-contract__page-break {
            page-break-after: always;
            border-bottom: none;
            margin-bottom: 0;
        }
        .staynets-contract__sig-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    @media (max-width: 700px) {
        .staynets-contract__header {
            flex-direction: column;
        }
        .staynets-contract__meta {
            text-align: left;
        }
        .staynets-contract__sig-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
