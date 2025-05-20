// Custom spinner style
const spinnerStyle = `
  .custom-spinner-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 10000;
  }
  
  .custom-spinner {
    width: 60px;
    height: 60px;
    border: 5px solid transparent;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
`;

// Add style to document
const addSpinnerStyle = () => {
  if (!document.getElementById('spinner-style')) {
    const styleElement = document.createElement('style');
    styleElement.id = 'spinner-style';
    styleElement.textContent = spinnerStyle;
    document.head.appendChild(styleElement);
  }
};

// Show loading spinner
const showLoading = () => {
  // Add style if not already added
  addSpinnerStyle();
  
  // Create spinner container if it doesn't exist
  if (!document.getElementById('custom-spinner-container')) {
    const spinnerContainer = document.createElement('div');
    spinnerContainer.id = 'custom-spinner-container';
    spinnerContainer.className = 'custom-spinner-container';
    
    const spinner = document.createElement('div');
    spinner.className = 'custom-spinner';
    
    spinnerContainer.appendChild(spinner);
    document.body.appendChild(spinnerContainer);
  } else {
    document.getElementById('custom-spinner-container').style.display = 'flex';
  }
};

// Hide loading spinner
const hideLoading = async () => {
  const spinnerContainer = document.getElementById('custom-spinner-container');
  if (spinnerContainer) {
    spinnerContainer.style.display = 'none';
  }
};

// Example usage:
// showLoading();  // Show the spinner
// setTimeout(hideLoading, 3000);  // Hide the spinner after 3 seconds