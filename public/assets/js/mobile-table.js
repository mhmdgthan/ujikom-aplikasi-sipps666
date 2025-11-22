// Mobile Table Scroll Handler
document.addEventListener('DOMContentLoaded', function() {
    const tableResponsive = document.querySelectorAll('.table-responsive');
    
    tableResponsive.forEach(function(container) {
        container.addEventListener('scroll', function() {
            if (this.scrollLeft > 0) {
                this.classList.add('scrolled');
            } else {
                this.classList.remove('scrolled');
            }
        });
    });
});