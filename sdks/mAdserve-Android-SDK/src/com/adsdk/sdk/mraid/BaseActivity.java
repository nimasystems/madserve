package com.adsdk.sdk.mraid;

import com.adsdk.sdk.video.ResourceManager;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.graphics.drawable.StateListDrawable;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.RelativeLayout;

public abstract class BaseActivity extends Activity {
    private static final float CLOSE_BUTTON_SIZE_DP = 50.0f;
    private static final float CLOSE_BUTTON_PADDING_DP = 8.0f;
    
    private ImageView mCloseButton;
    private RelativeLayout mLayout;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN);
        
        mLayout = new RelativeLayout(this);
        final RelativeLayout.LayoutParams adViewLayout = new RelativeLayout.LayoutParams(
                RelativeLayout.LayoutParams.MATCH_PARENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
        adViewLayout.addRule(RelativeLayout.CENTER_IN_PARENT);
        mLayout.addView(getAdView(), adViewLayout);
        setContentView(mLayout);
        
        showInterstitialCloseButton();
    }
    
    public abstract View getAdView();
    
    @SuppressWarnings("deprecation")
	@SuppressLint("NewApi")
	protected void showInterstitialCloseButton() {
        if (mCloseButton == null) {
            StateListDrawable states = new StateListDrawable();
            states.addState(new int[] {-android.R.attr.state_pressed},ResourceManager.getStaticResource(this, ResourceManager.DEFAULT_CLOSE_BUTTON_NORMAL_RESOURCE_ID));
            states.addState(new int[] {android.R.attr.state_pressed},ResourceManager.getStaticResource(this, ResourceManager.DEFAULT_CLOSE_BUTTON_PRESSED_RESOURCE_ID));
            mCloseButton = new ImageButton(this);
            mCloseButton.setImageDrawable(states);
            
            int sdk = android.os.Build.VERSION.SDK_INT;
            if(sdk < android.os.Build.VERSION_CODES.JELLY_BEAN) {
            	mCloseButton.setBackgroundDrawable(null);
            } else {
            	mCloseButton.setBackground(null);
            }
            
            mCloseButton.setOnClickListener(new OnClickListener() {
                public void onClick(View v) {
                    finish();
                }
            });
        }
        
        final float scale = getResources().getDisplayMetrics().density;
        int buttonSize = (int) (CLOSE_BUTTON_SIZE_DP * scale + 0.5f);
        int buttonPadding = (int) (CLOSE_BUTTON_PADDING_DP * scale + 0.5f);
        RelativeLayout.LayoutParams buttonLayout = new RelativeLayout.LayoutParams(
                buttonSize, buttonSize);
        buttonLayout.addRule(RelativeLayout.ALIGN_PARENT_RIGHT);
        buttonLayout.setMargins(buttonPadding, 0, buttonPadding, 0);
        mLayout.removeView(mCloseButton);
        mLayout.addView(mCloseButton, buttonLayout);
    }
    
    protected void hideInterstitialCloseButton() {
        mLayout.removeView(mCloseButton);
    }
    
    @Override
    protected void onDestroy() {
        mLayout.removeAllViews();
        super.onDestroy();
    }
}
