function printTable() {
    var printWindow = window.open('', '', 'height=600,width=800');
    var content = document.getElementById('printableTable').outerHTML;
    
    printWindow.document.write('<html><head><title>Print Table</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; font-size: 14px; }');
    printWindow.document.write('table { border-collapse: collapse; width: 100%; }');
    printWindow.document.write('td { padding: 8px; text-align: left; border: 1px solid black; }');
    printWindow.document.write('th { white-space: nowrap; writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; }'); // Vertical headers
    printWindow.document.write('h2, h3 { text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>Branch Data</h2>'); // Change this text as per your needs
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    printWindow.print();
}
